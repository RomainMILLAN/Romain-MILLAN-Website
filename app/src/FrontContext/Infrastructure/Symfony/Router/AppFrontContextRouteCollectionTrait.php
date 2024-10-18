<?php

declare(strict_types=1);

namespace App\FrontContext\Infrastructure\Symfony\Router;

trait AppFrontContextRouteCollectionTrait
{
    public function prefixed(): string
    {
        return 'app_' . $this->value;
    }
}
