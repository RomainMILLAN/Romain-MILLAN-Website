<?php

namespace Panel\Infrastructure\Symfony\Controller;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Panel\Infrastructure\Symfony\Router\AppPanelContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppPanelContextRouteCollectionTrait;

    case DASHBOARD = 'dashboard';
    case PROD_01_UPTIME_KUMA = 'prod_01_uptime_kuma';
    case CLOUD_UPTIME_ROBOT = 'cloud_uptime_robot';
    case PROD_01_DOCKGE = 'prod_01_dockge';
}
