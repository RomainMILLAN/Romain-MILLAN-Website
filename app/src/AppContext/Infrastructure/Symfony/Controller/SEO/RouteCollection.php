<?php

declare(strict_types=1);

namespace App\AppContext\Infrastructure\Symfony\Controller\SEO;

use App\AppContext\Infrastructure\Symfony\Router\AppSEORouteCollectionTrait;
use App\AppContext\Infrastructure\Symfony\Router\RouteCollectionInterface;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppSEORouteCollectionTrait;

    case ROBOTS_TXT = 'robots';

    case SITEMAP_INDEX = 'sitemap_index';

    case SITEMAP_PAGES = 'sitemap_pages';
}
