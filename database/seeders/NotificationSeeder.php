<?php

namespace Database\Seeders;

use App\Models\{Notification, OpportunityStateDetail};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opportunityStateDetails = OpportunityStateDetail::all();

        foreach ($opportunityStateDetails as $opportunityStateDetail) {
            $notification = [
                'opportunity_state_id' => $opportunityStateDetail->opportunity_state_id,
                'receiver_id' => $opportunityStateDetail->opportunityState->created_by,
                'sender_id' => $opportunityStateDetail->created_by,
                'created_at' => $opportunityStateDetail->created_at,
            ];

            Notification::insert($notification);
        }
    }
}
