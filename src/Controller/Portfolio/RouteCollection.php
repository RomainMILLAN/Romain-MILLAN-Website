<?php

declare(strict_types=1);

namespace App\Controller\Portfolio;

use App\Controller\AppRouteCollectionTrait;
use App\Controller\RouteCollectionInterface;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppRouteCollectionTrait;

    case HOMEPAGE = 'homepage';
    case PORTFOLIO = 'portfolio';
    case PROJECT = 'project';
}
