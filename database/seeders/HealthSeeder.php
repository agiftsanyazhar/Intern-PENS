<?php

namespace Database\Seeders;

use App\Models\Health;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $healths = [
            [
                'status_health' => 'Good',
                'day_parameter_value' => 5,
            ],
            [
                'status_health' => 'Fair',
                'day_parameter_value' => 10,
            ],
            [
                'status_health' => 'Poor',
                'day_parameter_value' => 20,
            ],
            [
                'status_health' => 'Critical',
                'day_parameter_value' => 30,
            ],
        ];

        foreach ($healths as $health) {
            Health::create($health);
        }
    }
}
