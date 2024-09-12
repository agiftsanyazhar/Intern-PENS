<?php

namespace App\Jobs;

use App\Models\{
    Health,
    OpportunityState
};
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
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

        OpportunityState::chunk(100, function ($opportunityStates) use ($getCurrentDate) {
            foreach ($opportunityStates as $opportunityState) {
                $dateToCompare = $opportunityState->updated_by ? $opportunityState->updated_at : $opportunityState->created_at;

                $daysDifference = $dateToCompare->diffInDays($getCurrentDate);

                $health = Health::where('day_parameter_value', '<=', $daysDifference)
                    ->orderBy('day_parameter_value', 'desc')
                    ->first();

                if ($health) {
                    $opportunityState->health_id = $health->id;
                    $opportunityState->save();
                }
            }
        });
    }
}
