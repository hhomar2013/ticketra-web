<?php

namespace App\Core\Enum;

enum AssetReturnStatus: string
{
    case DAMAGED = 'damaged';
    case LEAVER = 'leaver';
    case REPLACEMENT = 'replacement';
    case RETURNED = 'returned';

    public function label(): string
    {
        return match ($this) {
            self::DAMAGED => __('Damaged'),
            self::LEAVER => __('Left at work'),
            self::REPLACEMENT => __('Replacement'),
            self::RETURNED => __('Returned'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DAMAGED => 'text-danger',
            self::LEAVER => 'text-warning',
            self::REPLACEMENT => 'text-success',
            self::RETURNED => 'text-info',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::DAMAGED => 'fa-regular fa-circle-xmark',
            self::LEFT_AT_WORK => 'fa-regular fa-clock',
            self::REPLACEMENT => 'fa-regular fa-arrows-exchange',
            self::RETURNED => 'fa-regular fa-circle-check',
        };
    }

}
