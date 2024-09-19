<?php

namespace Database\Seeders;

use App\Models\OpportunityState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpportunityStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opportunityStates = [];
        for ($i = 0; $i < 10000; $i++) {
            $opportunityStates[] = [
                'customer_id' => rand(1, 10000),
                'opportunity_status_id' => rand(1, 5),
                'opportunity_value' => rand(1000000, 50000000),
                'title' => 'Judul ' . $i,
                'description' => 'Deskripsi ' . $i,
                'created_at' => fake()->dateTimeBetween('-5 years', 'now'),
                'created_by' => rand(1, 1004),
            ];
        }

        foreach ($opportunityStates as $opportunityState) {
            OpportunityState::insert($opportunityState);
        }
    }
}
