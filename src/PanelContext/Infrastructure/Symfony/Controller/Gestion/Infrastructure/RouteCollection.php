<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\Infrastructure;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Panel\Infrastructure\Symfony\Router\AppPanelContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppPanelContextRouteCollectionTrait;

    case EDIT = 'gestion_infrastructure_edit';
}
