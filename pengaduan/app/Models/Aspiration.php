<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aspiration extends Model
{
    protected $fillable = [
        'category_id',
        'judul',
        'isi',
        'owner_token',
        'upvote',
        'downvote',
    ];

    /**
     * Get the category that owns the aspiration.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the comments for the aspiration.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the votes for the aspiration.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
