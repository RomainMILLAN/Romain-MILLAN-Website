<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\Signature;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Panel\Infrastructure\Symfony\Router\AppPanelContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppPanelContextRouteCollectionTrait;

    case CREATE = 'gestion_signature_create';
}
