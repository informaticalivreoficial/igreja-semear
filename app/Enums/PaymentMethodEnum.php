<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case Pix = 'pix';
    case Card = 'card';

    public function label(): string
    {
        return match ($this) {
            self::Pix => 'PIX',
            self::Card => 'Cartão',
        };
    }

    public static function labels(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->all();
    }
}
