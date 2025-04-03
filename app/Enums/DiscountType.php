<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DiscountType: string implements HasLabel
{
    case FIXED = 'fixed';
    case PERCENTAGE = 'percentage';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FIXED => __('discount-type-enum.fixed.label'),
            self::PERCENTAGE => __('discount-type-enum.percentage.label'),
        };
    }
}
