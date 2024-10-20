<?php

namespace App\PanelContext\Infrastructure\Symfony\Controller;

use App\AppContext\Infrastructure\Symfony\Router\RouteCollectionInterface;
use App\PanelContext\Infrastructure\Symfony\Router\AppPanelContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppPanelContextRouteCollectionTrait;

    case DASHBOARD = 'dashboard';
    case PROD_01_UPTIME_KUMA = 'prod_01_uptime_kuma';
    case CLOUD_UPTIME_ROBOT = 'cloud_uptime_robot';
}
