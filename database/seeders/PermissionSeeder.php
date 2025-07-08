<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'View', 'code' => 'can_view', 'action_name' => 'index', 'http_method' => 'GET'],
            ['name' => 'View Detail', 'code' => 'can_view_detail', 'action_name' => 'show', 'http_method' => 'GET'],
            ['name' => 'Create', 'code' => 'can_create', 'action_name' => 'create', 'http_method' => 'GET'],
            ['name' => 'Store', 'code' => 'can_store', 'action_name' => 'store', 'http_method' => 'POST'],
            ['name' => 'Edit', 'code' => 'can_edit', 'action_name' => 'edit', 'http_method' => 'GET'],
            ['name' => 'Update', 'code' => 'can_update', 'action_name' => 'update', 'http_method' => 'PUT'],
            ['name' => 'Delete', 'code' => 'can_delete', 'action_name' => 'destroy', 'http_method' => 'DELETE'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
