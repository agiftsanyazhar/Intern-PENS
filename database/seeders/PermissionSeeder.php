<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{
    Permission,
};

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'role',
                'title' => 'Role',
            ],
            [
                'name' => 'role-add',
                'title' => 'Role Add',
                'parent_id' => 1,
            ],
            [
                'name' => 'role-list',
                'title' => 'Role List',
                'parent_id' => 1,
            ],
            [
                'name' => 'permission',
                'title' => 'Permission',
            ],
            [
                'name' => 'permission-add',
                'title' => 'Permission Add',
                'parent_id' => 4,
            ],
            [
                'name' => 'permission-list',
                'title' => 'Permission List',
                'parent_id' => 4,
            ],
            [
                'name' => 'view-admin',
                'title' => 'View Admin',
            ],
            [
                'name' => 'view-division-head',
                'title' => 'View Division Head',
            ],
            [
                'name' => 'view-sales-head',
                'title' => 'View Sales Head',
            ],
            [
                'name' => 'view-sales',
                'title' => 'View Sales',
            ],
        ];

        foreach ($permissions as $value) {
            Permission::create($value);
        }
    }
}
