<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\SEO;

use App\Infrastructure\Symfony\Router\AppSEORouteCollectionTrait;
use App\Infrastructure\Symfony\Router\RouteCollectionInterface;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppSEORouteCollectionTrait;

    case ROBOTS_TXT = 'robots';

    case SITEMAP_INDEX = 'sitemap_index';

    case SITEMAP_PAGES = 'sitemap_pages';
}
