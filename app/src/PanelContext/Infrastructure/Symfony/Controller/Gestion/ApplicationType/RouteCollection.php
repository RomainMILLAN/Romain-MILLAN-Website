<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\ApplicationType;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Panel\Infrastructure\Symfony\Router\AppPanelContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppPanelContextRouteCollectionTrait;

    case LIST = 'gestion_application_type_list';
    case CREATE = 'gestion_application_type_create';
    case EDIT = 'gestion_application_type_edit';
    case DELETE = 'gestion_application_type_delete';
}
