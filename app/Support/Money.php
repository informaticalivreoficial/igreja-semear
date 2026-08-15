<?php

namespace App\Support;

class Money
{
    public static function normalize(mixed $value): float
    {
        if (is_numeric($value)) {
            return (float) $value;
        }

        $value = trim((string) $value);

        $isBrl = str_contains($value, ',');
        $value = preg_replace('/[^\d.,]/', '', $value) ?? '';

        if ($isBrl) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        }

        return (float) $value;
    }

    public static function format(float $value): string
    {
        return number_format($value, 2, ',', '.');
    }
}
