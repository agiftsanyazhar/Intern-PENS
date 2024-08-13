<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
};

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the opportunityState that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opportunityState(): BelongsTo
    {
        return $this->belongsTo(OpportunityState::class);
    }
}
