<?php

namespace Database\Seeders;

use App\Models\Access;
use App\Models\Menu;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $role = Role::find(1);
        $menus = Menu::all();

        $accessArray = [];
        foreach ($menus as $key => $value) {
            $accessArray = [
                'menu_id' => $value->id,
                'role_id' => $role->id,
                'can_view' => 1,
                'can_create' => 1,
                'can_edit' => 1,
                'can_delete' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            Access::insert($accessArray);
        }

    }
}
