<?php

declare(strict_types=1);

namespace App\FrontContext\Infrastructure\Symfony\Controller;

use App\AppContext\Infrastructure\Symfony\Router\RouteCollectionInterface;
use App\FrontContext\Infrastructure\Symfony\Router\AppFrontContextRouteCollectionTrait;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppFrontContextRouteCollectionTrait;

    case PORTFOLIO = 'portfolio';
    case TERMS_OF_USE = 'terms_of_use';

    case UI = 'ui';
}
