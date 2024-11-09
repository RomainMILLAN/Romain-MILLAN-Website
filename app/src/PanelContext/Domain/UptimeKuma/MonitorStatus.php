<?php

namespace App\PanelContext\Domain\UptimeKuma;

enum MonitorStatus: string
{
    case UP = 'up';
    case DOWN = 'down';
    case PENDING = 'pending';
    case MAINTENANCE = 'maintenance';

    public static function fromAPIValue(int $value): self
    {
        return match ($value) {
            0 => self::DOWN,
            1 => self::UP,
            2 => self::PENDING,
            3 => self::MAINTENANCE,
        };
    }
}
