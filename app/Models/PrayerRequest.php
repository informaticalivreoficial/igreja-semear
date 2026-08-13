<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrayerRequest extends Model
{
    use HasFactory;

    public const STATUS_PENDENTE = 'pendente';

    public const STATUS_RESPONDIDO = 'respondido';

    protected $fillable = [
        'member_id',
        'name',
        'email',
        'phone',
        'message',
        'status',
        'answer',
        'answered_by',
        'answered_at',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function answeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'answered_by');
    }
}
