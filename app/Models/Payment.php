<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentMethodEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = [
        'uuid',
        'payable_type',
        'payable_id',
        'amount',
        'method',
        'status',
        'gateway',
        'gateway_id',
        'gateway_reference',
        'gateway_payload',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_payload' => 'array',
        'paid_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Payment $payment) {
            if (empty($payment->uuid)) {
                $payment->uuid = (string) Str::uuid();
            }
        });
    }

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeByGatewayId($query, string $gatewayId)
    {
        return $query->where('gateway_id', $gatewayId);
    }

    public function markAsPaid(?\DateTimeInterface $paidAt = null): void
    {
        $this->status = PaymentStatusEnum::Paid->value;
        $this->paid_at = $paidAt ?? now();

        $this->save();
    }

    public function markAsFailed(): void
    {
        $this->status = PaymentStatusEnum::Failed->value;
        $this->save();
    }

    public function markAsCancelled(): void
    {
        $this->status = PaymentStatusEnum::Cancelled->value;
        $this->save();
    }

    public function markAsRefunded(): void
    {
        $this->status = PaymentStatusEnum::Refunded->value;
        $this->save();
    }

    public function isPaid(): bool
    {
        return $this->status === PaymentStatusEnum::Paid->value;
    }

    public function getMethodLabelAttribute(): string
    {
        return PaymentMethodEnum::from($this->method)?->label() ?? $this->method;
    }
}
