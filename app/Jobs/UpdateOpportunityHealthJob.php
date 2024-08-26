<?php

namespace App\Jobs;

use App\Models\{Health, OpportunityState};
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\{
    InteractsWithQueue,
    SerializesModels
};

class UpdateOpportunityHealthJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $getCurrentDate = Carbon::now();

        $opportunityStates = OpportunityState::all();

        foreach ($opportunityStates as $opportunityState) {
            // Determine the relevant date to calculate the difference
            $dateToCompare = $opportunityState->updated_by ? $opportunityState->updated_at : $opportunityState->created_at;

            // Calculate the difference in days
            $daysDifference = Carbon::parse($dateToCompare)->diffInDays($getCurrentDate);

            // Find the appropriate health based on the day parameter
            $health = Health::firstWhere('day_parameter_value', '>=', $daysDifference);

            // Update the health_id if a matching health record is found
            if ($health) {
                $opportunityState->health_id = $health->id;
                $opportunityState->save();
            }
        }
    }
}
