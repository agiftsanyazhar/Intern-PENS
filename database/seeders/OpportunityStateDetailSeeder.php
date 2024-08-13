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
                'opportunity_name' => 'Name 1',
                'opportunity_state_id' => 1,
                'description' => 'Ini deskripsi 1',
                'created_by' => 1,
            ],
            [
                'opportunity_name' => 'Name 2',
                'opportunity_state_id' => 1,
                'description' => 'Ini deskripsi 2',
                'created_by' => 1,
            ],
            [
                'opportunity_name' => 'Name 3',
                'opportunity_state_id' => 2,
                'description' => 'Ini deskripsi 3',
                'created_by' => 1,
            ],
            [
                'opportunity_name' => 'Name 4',
                'opportunity_state_id' => 2,
                'description' => 'Ini deskripsi 4',
                'created_by' => 1,
            ],
            [
                'opportunity_name' => 'Name 5',
                'opportunity_state_id' => 3,
                'description' => 'Ini deskripsi 5',
                'created_by' => 1,
            ],
        ];

        foreach ($opportunityStateDetails as $item) {
            OpportunityStateDetail::create($item);
        }
    }
}
