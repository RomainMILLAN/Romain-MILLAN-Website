<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\DocTag;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Panel\Infrastructure\Symfony\Router\AppPanelContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppPanelContextRouteCollectionTrait;

    case LIST = 'gestion_doc_tag_list';
    case CREATE = 'gestion_doc_tag_create';
    case EDIT = 'gestion_doc_tag_edit';
    case DELETE = 'gestion_doc_tag_delete';
}
