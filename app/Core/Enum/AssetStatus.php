<?php

namespace App\Core\Enum;

enum AssetStatus: string
{
    case Pending = 'pending';
    case Assigned = 'assigned';
    case Available = 'available';
    case Broken = 'broken';
    case Lost = 'lost';
    case Sold = 'sold';
    case Stocked = 'stocked';
    case Damaged = 'damaged';
    case Retired = 'retired';
    case Maintenance = 'maintenance';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Assigned => 'Assigned',
            self::Available => 'Available',
            self::Broken => 'Broken',
            self::Lost => 'Lost',
            self::Sold => 'Sold',
            self::Stocked => 'Stocked',
            self::Damaged => 'Damaged',
            self::Retired => 'Retired',
            self::Maintenance => 'Maintenance',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::Assigned => 'badge badge-primary',
            self::Available => 'badge badge-success',
            self::Broken => 'badge badge-danger',
            self::Lost => 'badge badge-warning',
            self::Sold => 'badge badge-info',
            self::Stock => 'badge badge-secondary',
            self::Damaged => 'badge badge-danger',
            self::Retired => 'badge badge-dark',
        };
    }




}