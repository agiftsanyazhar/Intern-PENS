<?php

namespace App\Console\Commands;

use App\Models\{
    Health,
    OpportunityState,
};
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateOpportunityHealth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:opportunity-health';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update opportunity health';

    /**
     * Execute the console command.
     */
    public function handle()
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
