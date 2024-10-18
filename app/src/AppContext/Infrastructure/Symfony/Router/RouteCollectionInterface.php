<?php

declare(strict_types=1);

namespace App\AppContext\Infrastructure\Symfony\Router;

interface RouteCollectionInterface
{
    public function prefixed(): string;
}
