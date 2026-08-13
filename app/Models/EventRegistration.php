<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    use HasFactory;

    public const STATUS_PENDENTE = 'pendente';

    public const STATUS_CONFIRMADA = 'confirmada';

    public const STATUS_CANCELADA = 'cancelada';

    protected $fillable = [
        'event_id',
        'member_id',
        'status',
        'notes',
        'created_by',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
