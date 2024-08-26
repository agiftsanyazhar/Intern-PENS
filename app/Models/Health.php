<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes
};
use Illuminate\Database\Eloquent\Relations\{
    HasMany,
};

class Health extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function opportunityState(): HasMany
    {
        return $this->hasMany(OpportunityState::class);
    }
}
