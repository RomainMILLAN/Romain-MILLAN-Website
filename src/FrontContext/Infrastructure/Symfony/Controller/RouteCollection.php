<?php

declare(strict_types=1);

namespace Front\Infrastructure\Symfony\Controller;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Front\Infrastructure\Symfony\Router\AppFrontContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppFrontContextRouteCollectionTrait;

    case UI = 'ui';
}
