<?php

namespace Panel\Domain\UptimeKuma;

use Panel\Domain\Exception\APIDataNotFound;

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
            default => throw new APIDataNotFound(),
        };
    }
}
