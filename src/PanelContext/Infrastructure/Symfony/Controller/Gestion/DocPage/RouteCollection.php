<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\DocPage;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Panel\Infrastructure\Symfony\Router\AppPanelContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppPanelContextRouteCollectionTrait;

    case INDEX = 'gestion_doc_page_index';
    case SHOW = 'gestion_doc_page_show';
    case CREATE = 'gestion_doc_page_create';
    case SAVE = 'gestion_doc_page_save';
    case DELETE = 'gestion_doc_page_delete';
    case SEARCH_API = 'gestion_doc_page_search_api';
}
