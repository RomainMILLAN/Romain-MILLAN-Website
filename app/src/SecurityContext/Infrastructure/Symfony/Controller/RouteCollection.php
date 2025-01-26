<?php

namespace Security\Infrastructure\Symfony\Controller;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Security\Infrastructure\Symfony\Router\AppSecurityContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppSecurityContextRouteCollectionTrait;

    case LOGIN = 'login';
    case LOGOUT = 'logout';
}
