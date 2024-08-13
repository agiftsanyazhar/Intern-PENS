<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'title' => 'Admin',
                'permissions' => ['role', 'role-add', 'role-list', 'permission', 'permission-add', 'permission-list', 'view-admin', 'view-division-head', 'view-sales-head', 'view-sales']
            ],
            [
                'name' => 'division-head',
                'title' => 'Division Head',
                'permissions' => ['view-division-head', 'view-sales-head', 'view-sales']
            ],
            [
                'name' => 'sales-head',
                'title' => 'Sales Head',
                'permissions' => ['view-sales-head', 'view-sales']
            ],
            [
                'name' => 'sales',
                'title' => 'Sales',
                'permissions' => ['view-sales']
            ],
        ];

        foreach ($roles as $key => $value) {
            $permission = $value['permissions'];
            unset($value['permissions']);
            $role = Role::create($value);
            $role->givePermissionTo($permission);
        }
    }
}
