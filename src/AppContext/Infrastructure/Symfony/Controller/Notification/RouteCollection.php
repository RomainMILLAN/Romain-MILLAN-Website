<?php

namespace App\Infrastructure\Symfony\Controller\Notification;

use App\Infrastructure\Symfony\Router\AppNotificationCollectionTrait;
use App\Infrastructure\Symfony\Router\RouteCollectionInterface;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppNotificationCollectionTrait;

    case REGISTER = 'register';
}
