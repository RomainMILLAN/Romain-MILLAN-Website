<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Router;

trait AppRouteCollectionTrait
{
    public function prefixed(): string
    {
        return 'app_' . $this->value;
    }
}
