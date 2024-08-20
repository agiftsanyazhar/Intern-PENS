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
                'role_id' => '1',
            ],
            [
                'name' => 'Division Head',
                'email' => 'division-head@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => '2',
            ],
            [
                'name' => 'Sales Head',
                'email' => 'sales-head@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => '3',
            ],
            [
                'name' => 'Sales',
                'email' => 'sales@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => '4',
            ],
        ];

        foreach ($users as $key => $value) {
            $user = User::create($value);
            $user->assignRole($value['role_id']);
        }
    }
}
