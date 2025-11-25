<?php

namespace Panel\Infrastructure\Symfony\Controller;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Panel\Infrastructure\Symfony\Router\AppPanelContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppPanelContextRouteCollectionTrait;

    case DASHBOARD = 'dashboard';
    case INFRASTRUCTURE = 'infrastructure';
    case SEARCH = 'search';
    case APPLICATION_INTERFACE = 'application_interface';
    case APPLICATIONS_SEARCH_API = 'application_search_api';
}
