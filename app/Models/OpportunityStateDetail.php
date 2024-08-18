<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes,
};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpportunityStateDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function opportunityState(): BelongsTo
    {
        return $this->belongsTo(OpportunityState::class);
    }
}