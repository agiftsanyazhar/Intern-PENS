<?php

namespace Database\Seeders;

use App\Models\OpportunityStateDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpportunityStateDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opportunityStateDetails = [
            [
                'opportunity_state_id' => 1,
                'opportunity_status_id' => 1,
                'description' => 'First opportunity state detail data',
                'created_by' => 1
            ],
            [
                'opportunity_state_id' => 1,
                'opportunity_status_id' => 2,
                'description' => 'Second opportunity state detail data',
                'created_by' => 1
            ],
            [
                'opportunity_state_id' => 1,
                'opportunity_status_id' => 3,
                'description' => 'Third opportunity state detail data',
                'created_by' => 1
            ],
            [
                'opportunity_state_id' => 2,
                'opportunity_status_id' => 4,
                'description' => 'Fourth opportunity state detail data',
                'created_by' => 1
            ],
            [
                'opportunity_state_id' => 3,
                'opportunity_status_id' => 5,
                'description' => 'Fifth opportunity state detail data',
                'created_by' => 1
            ],
        ];

        foreach ($opportunityStateDetails as $opportunityStateDetail) {
            OpportunityStateDetail::create($opportunityStateDetail);
        }
    }
}
