<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\InfrastructureService;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Panel\Infrastructure\Symfony\Router\AppPanelContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppPanelContextRouteCollectionTrait;

    case LIST = 'gestion_infrastructure_service_list';
    case CREATE = 'gestion_infrastructure_service_create';
    case EDIT = 'gestion_infrastructure_service_edit';
    case DELETE = 'gestion_infrastructure_service_delete';
}
