<?php

namespace App\Models;

use App\Support\AnonymousIdentity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aspiration extends Model
{
    protected $fillable = [
        'category_id',
        'judul',
        'isi',
        'upvote',
        'downvote',
    ];

    protected $hidden = ['author_hash'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function isAuthoredBy(?User $user): bool
    {
        return $user !== null
            && $this->author_hash !== null
            && hash_equals($this->author_hash, AnonymousIdentity::authorHash($user));
    }

    public function scopeAuthoredBy($query, User $user)
    {
        return $query->where('author_hash', AnonymousIdentity::authorHash($user));
    }

    public function reportCount(): int
    {
        return $this->reports_count ?? $this->reports()->count();
    }

    public function reachedReportThreshold(): bool
    {
        return $this->reportCount() >= config('pengaduan.report_threshold');
    }
}
