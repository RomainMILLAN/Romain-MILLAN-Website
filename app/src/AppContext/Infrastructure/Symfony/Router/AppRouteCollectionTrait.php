<?php

declare(strict_types=1);

namespace App\AppContext\Infrastructure\Symfony\Router;

trait AppRouteCollectionTrait
{
    public function prefixed(): string
    {
        return 'app_' . $this->value;
    }
}
