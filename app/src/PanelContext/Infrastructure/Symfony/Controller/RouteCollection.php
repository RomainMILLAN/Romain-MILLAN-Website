<?php

namespace Panel\Infrastructure\Symfony\Controller;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Panel\Infrastructure\Symfony\Router\AppPanelContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppPanelContextRouteCollectionTrait;

    case DASHBOARD = 'dashboard';
    case INFRASTRUCTURE = 'infrastructure';
    case APPLICATION_INTERFACE = 'application_interface';
}
