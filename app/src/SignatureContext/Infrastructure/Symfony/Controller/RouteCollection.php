<?php

namespace Signature\Infrastructure\Symfony\Controller;

use App\Infrastructure\Symfony\Router\RouteCollectionInterface;
use Signature\Infrastructure\Symfony\Router\AppSignatureContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppSignatureContextRouteCollectionTrait;

    case CREATE = 'create';
}
