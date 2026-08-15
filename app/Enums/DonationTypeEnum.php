<?php

namespace App\Enums;

enum DonationTypeEnum: string
{
    case Tithe = 'tithe';
    case Offering = 'offering';
    case Donation = 'donation';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Tithe => 'Dízimo',
            self::Offering => 'Oferta',
            self::Donation => 'Doação',
            self::Other => 'Outro',
        };
    }

    public static function labels(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->all();
    }
}
