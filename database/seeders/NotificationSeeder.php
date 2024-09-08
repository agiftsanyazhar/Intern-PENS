<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'opportunity_state_id' => 1,
                'receiver_id' => 2,
                'sender_id' => 1,
                'created_at' => '2024-09-05 00:05:00',
            ],
            [
                'opportunity_state_id' => 2,
                'receiver_id' => 2,
                'sender_id' => 2,
                'created_at' => '2024-09-05 00:06:00',
            ],
            [
                'opportunity_state_id' => 4,
                'receiver_id' => 2,
                'sender_id' => 3,
                'created_at' => '2024-09-05 00:07:00',
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }
    }
}
