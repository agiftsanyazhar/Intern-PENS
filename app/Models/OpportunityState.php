<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    HasMany,
    HasOne,
};

class OpportunityState extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get all of the customer for the OpportunityState
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customer(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get the opportunityStateDetail associated with the OpportunityState
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function opportunityStateDetail(): HasOne
    {
        return $this->hasOne(OpportunityStateDetail::class);
    }
}
