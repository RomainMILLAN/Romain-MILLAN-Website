<?php

declare(strict_types=1);

namespace App\Controller;

trait AppRouteCollectionTrait
{
    public function prefixed(): string
    {
        return 'app_' . $this->value;
    }
}
