<?php

namespace App\Models;

use App\Enums\DonationStatusEnum;
use App\Enums\DonationTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'church_id',
        'member_id',
        'type',
        'description',
        'amount',
        'status',
        'payment_id',
        'is_anonymous',
        'source',
        'payment_method',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Donation $donation) {
            if (empty($donation->uuid)) {
                $donation->uuid = (string) Str::uuid();
            }
        });
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return DonationTypeEnum::from($this->type)?->label() ?? $this->type;
    }

    public function getStatusLabelAttribute(): string
    {
        return DonationStatusEnum::from($this->status)?->label() ?? $this->status;
    }

    public function getAmountFormattedAttribute(): string
    {
        return number_format((float) $this->amount, 2, ',', '.');
    }

    public function getSourceLabelAttribute(): string
    {
        return $this->source === 'manual' ? 'Manual' : 'Online';
    }

    public function getMethodLabelAttribute(): string
    {
        if ($this->source === 'manual') {
            return $this->payment_method ? ucfirst($this->payment_method) : '—';
        }

        return $this->payment?->method_label ?? '—';
    }

    public function getContributorNameAttribute(): string
    {
        if ($this->is_anonymous) {
            return 'Anônimo';
        }

        return $this->member?->user?->name ?? $this->member?->name ?? '—';
    }

    public function isPaid(): bool
    {
        return $this->status === DonationStatusEnum::Paid->value;
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', DonationStatusEnum::Paid->value);
    }
}
