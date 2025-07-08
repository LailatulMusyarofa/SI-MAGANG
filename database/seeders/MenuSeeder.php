<?php

namespace Database\Seeders;

use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $menuArray = [
            [
                'id' => 1,
                'name' => 'Beranda',
                'icon' => 'mdi-home',
                'parent_id' => null,
                'url' => 'home',
                'order' => 1,
                'is_active' => true,
                'match_segment' => 'home',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'id' => 2,
                'name' => 'Master',
                'icon' => 'mdi-text-box-multiple',
                'parent_id' => null,
                'url' => null,
                'order' => 2,
                'is_active' => true,
                'match_segment' => 'master',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'id' => 3,
                'name' => 'Menu',
                'icon' => null,
                'parent_id' => 2,
                'url' => 'menu.index',
                'order' => 1,
                'is_active' => true,
                'match_segment' => 'menu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'id' => 4,
                'name' => 'Role & Permission',
                'icon' => null,
                'parent_id' => 2,
                'url' => null,
                'order' => 2,
                'is_active' => true,
                'match_segment' => 'role-&-permission',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Menu::insert($menuArray);
    }
}
