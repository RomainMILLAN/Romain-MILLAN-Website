<?php

declare(strict_types=1);

namespace App\SecurityContext\Infrastructure\Symfony\Router;

trait AppSecurityContextRouteCollectionTrait
{
    public function prefixed(): string
    {
        return 'app_security_' . $this->value;
    }
}
