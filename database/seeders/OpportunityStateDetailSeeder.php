<?php

namespace Database\Seeders;

use App\Models\{OpportunityState, OpportunityStateDetail};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpportunityStateDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opportunityStateDetails = [];
        for ($i = 0; $i < 2500; $i++) {
            $opportunityStateDetails[] = [
                'opportunity_state_id' => rand(1, 1200),
                'opportunity_status_id' => rand(1, 5),
                'description' => 'Opportunity state detail data ' . $i,
                'created_by' => rand(1, 504),
                'created_at' => fake()->date(),
            ];
        }

        foreach ($opportunityStateDetails as $opportunityStateDetail) {
            $opportunityStateDetailModel = OpportunityStateDetail::create($opportunityStateDetail);

            $opportunityState = OpportunityState::find($opportunityStateDetailModel->opportunity_state_id);
            $opportunityState->update([
                'opportunity_status_id' => $opportunityStateDetailModel->opportunity_status_id,
                'updated_by' => $opportunityStateDetailModel->created_by,
                'updated_at' => $opportunityStateDetailModel->created_at,
            ]);
        }
    }
}
