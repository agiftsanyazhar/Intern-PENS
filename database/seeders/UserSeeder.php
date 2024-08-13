<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ],
            [
                'name' => 'Division Head',
                'email' => 'division-head@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'division-head',
            ],
            [
                'name' => 'Sales Head',
                'email' => 'sales-head@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'sales-head',
            ],
            [
                'name' => 'Sales',
                'email' => 'sales@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'sales',
            ],
        ];

        foreach ($users as $key => $value) {
            $user = User::create($value);
            $user->assignRole($value['role']);
        }
    }
}
