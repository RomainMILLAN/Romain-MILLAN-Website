<?php

declare(strict_types=1);

namespace App\Controller;

interface RouteCollectionInterface
{
    public function prefixed(): string;
}
