<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpportunityStateDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function opportunityState(): BelongsTo
    {
        return $this->belongsTo(OpportunityState::class);
    }
}
