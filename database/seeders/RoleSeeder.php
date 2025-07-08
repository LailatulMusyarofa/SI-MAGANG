<?php

namespace Database\Seeders;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $roleArray = [
        //     [
        //         'name' => 'Superadmin',
        //         'is_active' => true,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'name' => 'Verifikator',
        //         'is_active' => true,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'name' => 'Perangkat Daerah',
        //         'is_active' => true,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        // ];

        // Role::insert($roleArray);

        $roles = [
            ['name' => 'Super Admin'],
            ['name' => 'User'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
