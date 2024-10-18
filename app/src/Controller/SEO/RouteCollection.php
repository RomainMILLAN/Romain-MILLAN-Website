<?php

declare(strict_types=1);

namespace App\Controller\SEO;

use App\Controller\AppRouteCollectionTrait;
use App\Controller\RouteCollectionInterface;

enum RouteCollection: string implements RouteCollectionInterface
{
    use AppSEORouteCollectionTrait;

    public const ROBOTS_TXT = 'robots';

    public const SITEMAP_INDEX = 'sitemap_index';

    public const SITEMAP_PAGES = 'sitemap_pages';
    public const SITEMAP_PROJECTS = 'sitemap_projects';
}
