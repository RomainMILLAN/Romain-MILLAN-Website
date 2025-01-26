<?php

declare(strict_types=1);

namespace Front\Infrastructure\Symfony\Router;

trait AppFrontContextRouteCollectionTrait
{
    public function prefixed(): string
    {
        return 'app_front_' . $this->value;
    }
}
