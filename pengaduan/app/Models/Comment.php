<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'aspiration_id',
        'isi',
        'owner_token',
    ];

    /**
     * Get the aspiration that owns the comment.
     */
    public function aspiration(): BelongsTo
    {
        return $this->belongsTo(Aspiration::class);
    }
}
