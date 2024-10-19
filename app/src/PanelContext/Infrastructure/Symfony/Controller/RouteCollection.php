<?php

namespace App\PanelContext\Infrastructure\Symfony\Controller;

use App\AppContext\Infrastructure\Symfony\Router\RouteCollectionInterface;
use App\PanelContext\Infrastructure\Symfony\Router\AppPanelContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppPanelContextRouteCollectionTrait;

    case DASHBOARD = 'dashboard';
}
