<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppRouteCollectionTrait;
use App\Controller\RouteCollectionInterface;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppRouteCollectionTrait;

    case HOMEPAGE = 'homepage';
}
