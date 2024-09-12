<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'role_id' => 1,
            ],
            [
                'name' => 'Division Head',
                'email' => 'division-head@gmail.com',
                'password' => bcrypt('12345678'),
                'role_id' => 2,
            ],
            [
                'name' => 'Sales Head',
                'email' => 'sales-head@gmail.com',
                'password' => bcrypt('12345678'),
                'role_id' => 3,
            ],
            [
                'name' => 'Sales',
                'email' => 'sales@gmail.com',
                'password' => bcrypt('12345678'),
                'role_id' => 4,
            ],
        ];

        foreach ($users as $key => $value) {
            $user = User::create($value);
            $user->assignRole($value['role_id']);
        }

        $users = [];
        for ($i = 0; $i < 500; $i++) {
            $name = ['Division Head ', 'Sales Head ', 'Sales '][rand(0, 2)] . $i;
            $email = match (true) {
                str_contains($name, 'Division Head') => 'division-head' . $i . '@gmail.com',
                str_contains($name, 'Sales Head') => 'sales-head' . $i . '@gmail.com',
                str_contains($name, 'Sales') => 'sales' . $i . '@gmail.com',
            };
            $role = match (true) {
                str_contains($name, 'Division Head') => 2,
                str_contains($name, 'Sales Head') => 3,
                str_contains($name, 'Sales') => 4,
            };

            $users[] = [
                'name' => $name,
                'email' => $email,
                'password' => bcrypt('12345678'),
                'role_id' => $role,
            ];
        }

        foreach ($users as $key => $value) {
            $user = User::create($value);
            $user->assignRole($value['role_id']);
        }
    }
}
