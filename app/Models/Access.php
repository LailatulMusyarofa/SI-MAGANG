<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Access extends Model
{
    //
    use HasFactory, SoftDeletes;

    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id')->where('is_active', true);
    }

    public function getSidebarMenu($roleId)
    {
        return $this->withWhereHas('menu', function($query) {
                $query->whereNull('parent_id')
                    ->where('is_active', true)
                    ->with('sub_menus');
            })
            ->where('role_id', $roleId)
            ->orderBy(function($query) {
                $query->select('order')
                    ->from('menus')
                    ->whereColumn('menus.id', 'accesses.menu_id')
                    ->limit(1);
            }, 'asc')
            ->get()
            ->toArray();
    }
}
