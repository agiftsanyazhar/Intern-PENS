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
                'opportunity_status' => 'Inquiry',
                'note' => 'Customer/sales just found the opportunity',
            ],
            [
                'opportunity_status' => 'Follow Up',
                'note' => 'Sales in progress acquiring detail',
            ],
            [
                'opportunity_status' => 'Stale',
                'note' => 'Customer/sales haven\'t give response for more than 5 working days',
            ],
            [
                'opportunity_status' => 'Completed',
                'note' => 'PO issued by customer',
            ],
            [
                'opportunity_status' => 'Failed',
                'note' => 'Customer cancel the opportunity / no reponse for more than 15 working days',
            ],
        ];

        foreach ($opportunityStates as $item) {
            OpportunityState::create($item);
        }
    }
}
