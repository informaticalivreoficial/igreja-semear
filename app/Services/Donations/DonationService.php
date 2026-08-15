<?php

namespace App\Services\Donations;

use App\Enums\DonationStatusEnum;
use App\Enums\DonationTypeEnum;
use App\Models\Donation;
use App\Models\Payment;
use App\Support\Money;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class DonationService
{
    public function createDonation(array $data): Donation
    {
        $type = DonationTypeEnum::tryFrom((string) data_get($data, 'type'));

        if (! $type) {
            throw new InvalidArgumentException('Tipo de doação inválido.');
        }

        $amount = Money::normalize(data_get($data, 'amount', 0));

        if ($amount <= 0) {
            throw new InvalidArgumentException('O valor da doação deve ser maior que zero.');
        }

        return Donation::create([
            'church_id' => data_get($data, 'church_id'),
            'member_id' => data_get($data, 'member_id'),
            'type' => $type->value,
            'description' => data_get($data, 'description'),
            'amount' => $amount,
            'status' => DonationStatusEnum::Pending->value,
            'is_anonymous' => (bool) data_get($data, 'is_anonymous', false),
        ]);
    }

    public function attachPayment(Donation $donation, Payment $payment): void
    {
        $donation->update(['payment_id' => $payment->id]);
    }

    public function markPaid(Donation $donation): void
    {
        $donation->update(['status' => DonationStatusEnum::Paid->value]);
    }

    public function markFailed(Donation $donation): void
    {
        $donation->update(['status' => DonationStatusEnum::Failed->value]);
    }

    public function markCancelled(Donation $donation): void
    {
        $donation->update(['status' => DonationStatusEnum::Cancelled->value]);
    }

    public function markRefunded(Donation $donation): void
    {
        $donation->update(['status' => DonationStatusEnum::Refunded->value]);
    }

    public function syncFromPayment(Donation $donation, Payment $payment): void
    {
        match ($payment->status) {
            'paid' => $this->markPaid($donation),
            'failed' => $this->markFailed($donation),
            'cancelled' => $this->markCancelled($donation),
            'refunded' => $this->markRefunded($donation),
            default => null,
        };
    }

    public function summarize(?array $filters = []): array
    {
        $query = Donation::query()
            ->where('status', DonationStatusEnum::Paid->value);

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (! empty($filters['start'])) {
            $query->whereDate('created_at', '>=', $filters['start']);
        }

        if (! empty($filters['end'])) {
            $query->whereDate('created_at', '<=', $filters['end']);
        }

        return [
            'total_amount' => (float) (clone $query)->sum('amount'),
            'total_count' => (clone $query)->count(),
        ];
    }

    public function totalsByType(?array $filters = []): array
    {
        return Donation::query()
            ->where('status', DonationStatusEnum::Paid->value)
            ->when(! empty($filters['start']), fn ($q) => $q->whereDate('created_at', '>=', $filters['start']))
            ->when(! empty($filters['end']), fn ($q) => $q->whereDate('created_at', '<=', $filters['end']))
            ->select('type', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->get()
            ->keyBy('type')
            ->map(function ($row) {
                $row->total = (float) $row->total;

                return $row;
            })
            ->all();
    }
}
