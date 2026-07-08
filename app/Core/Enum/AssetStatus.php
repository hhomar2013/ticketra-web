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
            self::Assigned => 'badge bg-primary rounded-pill shadow-sm px-3 text-white',
            self::Available => 'badge bg-success rounded-pill shadow-sm px-3 text-white',
            self::Broken => 'badge bg-danger rounded-pill shadow-sm px-3 text-white',
            self::Lost => 'badge bg-warning rounded-pill shadow-sm px-3 text-white',
            self::Sold => 'badge bg-info rounded-pill shadow-sm px-3 text-white',
            self::Stocked => 'badge bg-secondary rounded-pill shadow-sm px-3 text-white',
            self::Damaged => 'badge bg-danger rounded-pill shadow-sm text-white',
            self::Retired => 'badge bg-dark rounded-pill shadow-sm text-white',
            self::Maintenance => 'badge bg-warning rounded-pill shadow-sm px-3 text-white',
        };
    }




}