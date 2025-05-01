<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Router;

interface RouteCollectionInterface
{
    public function prefixed(): string;
}
