<?php

namespace App\PanelContext\Domain\UptimeKuma;

enum CertValidationStatus: string
{
    case VALIDATE = 'valid';
    case INVALID = 'invalid';

    public static function fromAPIValue(int $value): self
    {
        return match ($value) {
            0 => self::INVALID,
            1 => self::VALIDATE,
        };
    }
}
