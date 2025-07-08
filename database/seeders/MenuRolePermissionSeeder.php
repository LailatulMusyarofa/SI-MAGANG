<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuRolePermission;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $superadminRole = Role::where('name', 'Super Admin')->first();
        $userRole = Role::where('name', 'User')->first();
        $menus = Menu::all();
        $permissions = Permission::all();

        foreach ($menus as $menu) {
            // Super Admin gets all permissions
            foreach ($permissions as $permission) {
                MenuRolePermission::create([
                    'menu_id' => $menu->id,
                    'role_id' => $superadminRole->id,
                    'permission_id' => $permission->id,
                ]);
            }

            // User only gets view permission for home
            if ($menu->route_name === 'home.index') {
                $viewPermission = Permission::where('code', 'can_view')->first();
                MenuRolePermission::create([
                    'menu_id' => $menu->id,
                    'role_id' => $userRole->id,
                    'permission_id' => $viewPermission->id,
                ]);
            }
        }
    }
}
