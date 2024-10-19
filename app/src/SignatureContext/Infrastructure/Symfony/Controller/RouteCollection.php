<?php

namespace App\SignatureContext\Infrastructure\Symfony\Controller;

use App\AppContext\Infrastructure\Symfony\Router\RouteCollectionInterface;
use App\SignatureContext\Infrastructure\Symfony\Router\AppSignatureContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppSignatureContextRouteCollectionTrait;

    case CREATE = 'create';
    case GENERATE = 'generate';
}
