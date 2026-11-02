<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'aspiration_id',
        'reporter_hash',
        'alasan',
        'catatan',
    ];

    protected $hidden = ['reporter_hash'];

    public function aspiration(): BelongsTo
    {
        return $this->belongsTo(Aspiration::class);
    }

    public function alasanLabel(): string
    {
        return config('pengaduan.report_reasons')[$this->alasan] ?? $this->alasan;
    }
}
