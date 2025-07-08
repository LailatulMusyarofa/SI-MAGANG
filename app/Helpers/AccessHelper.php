<?php

namespace App\Helpers;

use App\Models\Menu;
use App\Models\MenuRolePermission;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AccessHelper
{
    /**
     * Set session akses user saat login.
     */
    public static function setUserAccessSession()
    {
        $loggedUser = Auth::user();
        if (!$loggedUser || !$loggedUser->is_active) {
            return;
        }
        
        if (!Session::has('sidebar_sess') || !Session::has('access_sess')) {

            $roleId = $loggedUser->role_id;

            // Ambil semua menu yang aktif dan punya akses untuk role ini
            $menus = Menu::where('is_active', true)
                ->whereExists(function ($query) use ($roleId) {
                    $query->from('menu_role_permissions')
                        ->whereColumn('menu_role_permissions.menu_id', 'menus.id')
                        ->where('menu_role_permissions.role_id', $roleId);
                })
                ->orderBy('order')
                ->get();

            // Susun menu untuk sidebar dengan struktur tree
            $sidebarMenu = self::buildSidebarMenu($menus);
            Session::put('sidebar_sess', $sidebarMenu);

            // Ambil semua permission user berdasarkan menu yang dimiliki
            $accessData = MenuRolePermission::where('role_id', $roleId)
                ->with(['menu', 'permission'])
                ->get()
                ->groupBy('menu_id')
                ->map(function ($permissions) {
                    return $permissions->mapWithKeys(function ($item) {
                        return [$item->permission->code => true]; // Simpan sebagai array boolean untuk akses cepat
                    });
                });

            Session::put('access_sess', $accessData);
        }
    }

    /**
     * Bangun struktur menu sidebar secara rekursif.
     */
    private static function buildSidebarMenu($menus, $parentId = null)
    {
        $result = [];

        foreach ($menus as $menu) {
            if ($menu->parent_id == $parentId) {
                $menuItem = $menu->toArray();
                $children = self::buildSidebarMenu($menus, $menu->id);
                if (!empty($children)) {
                    $menuItem['children'] = $children;
                }
                $result[] = $menuItem;
            }
        }


        return json_decode(json_encode($result));
    }

    /**
     * Ambil akses user berdasarkan url yang diakses.
     */
    public static function getUserAccessByUrl($url)
    {
        // Ambil menu ID berdasarkan URL yang cocok persis
        $menuId = (new Menu())->getMenuIdByUrl($url);
        // Jika tidak ada yang cocok, coba cari dengan pendekatan "like"
        if (!$menuId) {
            $urlSegment = explode('.', $url)[0]; // Ambil bagian utama dari URL
            $menuId = (new Menu())->getMenuIdLikeUrl($urlSegment);
        }
        if (!$menuId) return [];

        // Ambil akses user dari session berdasarkan menu_id
        $accessData = collect(Session::get('access_sess', []));

        return $accessData->get($menuId, []);
    }

    /**
     * Cek apakah user memiliki izin tertentu.
     */
    public static function hasAccess($action, $url, $method)
    {
        // Ambil permission dari database berdasarkan action name
        $requiredPermission = (new Permission())->getPermissionCodeByActionName($action);
        if (!$requiredPermission) return false;

        // Ambil method HTTP dari permission
        $requiredMethod = (new Permission())->getPermissionHttpMethodByActionName($action);
        if ($requiredMethod <> $method) return false;

        // Ambil izin user dari session
        $userAccess = self::getUserAccessByUrl($url);

        // Cek apakah user memiliki permission yang diperlukan
        return $userAccess && !empty($userAccess[$requiredPermission]);
    }

    /**
     * Refresh session akses user (dipanggil setelah update permission).
     */
    public static function refreshAccessSession()
    {
        Session::forget(['sidebar_sess', 'access_sess']);
        self::setUserAccessSession();
    }

    /**
     * Clear session akses user (dipanggil saat logout).
     */
    public static function clearAccessSession()
    {
        Session::forget(['sidebar_sess', 'access_sess']);
    }
}
