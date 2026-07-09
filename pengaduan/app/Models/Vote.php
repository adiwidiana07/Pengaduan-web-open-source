<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    protected $fillable = [
        'aspiration_id',
        'vote_type',
        'voter_token',
    ];

    /**
     * Get the aspiration that owns the vote.
     */
    public function aspiration(): BelongsTo
    {
        return $this->belongsTo(Aspiration::class);
    }
}
