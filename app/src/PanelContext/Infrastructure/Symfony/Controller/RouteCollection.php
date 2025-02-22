<?php

namespace Panel\Infrastructure\Symfony\Controller;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Panel\Infrastructure\Symfony\Router\AppPanelContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppPanelContextRouteCollectionTrait;

    case DASHBOARD = 'dashboard';
    case SERVICE_PROD_01_UPTIME_KUMA = 'service_prod_01_uptime_kuma';
    case SERVICE_PROD_01_DOCKGE = 'service_prod_01_dockge';
}
