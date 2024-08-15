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
        $opportunityStates = [
            [
                'customer_id' => 1,
                'opportunity_status_id' => 1,
                'opportunity_value' => 1000000,
                'title' => 'Judul 1',
                'description' => 'Deskripsi 1',
                'created_by' => 2,
            ],
            [
                'customer_id' => 2,
                'opportunity_status_id' => 2,
                'opportunity_value' => 2000000,
                'title' => 'Judul 2',
                'description' => 'Deskripsi 2',
                'created_by' => 3,
            ],
            [
                'customer_id' => 3,
                'opportunity_status_id' => 3,
                'opportunity_value' => 3000000,
                'title' => 'Judul 3',
                'description' => 'Deskripsi 3',
                'created_by' => 2,
            ],
        ];

        foreach ($opportunityStates as $item) {
            OpportunityState::create($item);
        }
    }
}
