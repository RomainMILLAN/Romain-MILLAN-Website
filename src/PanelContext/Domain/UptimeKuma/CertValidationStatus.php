<?php

namespace Panel\Domain\UptimeKuma;

use Panel\Domain\Exception\APIDataNotFound;

enum CertValidationStatus: string
{
    case VALIDATE = 'valid';
    case INVALID = 'invalid';

    public static function fromAPIValue(int $value): self
    {
        return match ($value) {
            0 => self::INVALID,
            1 => self::VALIDATE,
            default => throw new APIDataNotFound(),
        };
    }
}
