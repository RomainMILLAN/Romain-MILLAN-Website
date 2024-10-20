<?php

namespace App\SecurityContext\Infrastructure\Symfony\Controller;

use App\AppContext\Infrastructure\Symfony\Router\RouteCollectionInterface;
use App\SecurityContext\Infrastructure\Symfony\Router\AppSecurityContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppSecurityContextRouteCollectionTrait;

    case LOGIN = 'login';
    case LOGOUT = 'logout';
}
