<?php

declare(strict_types=1);

namespace App\Controller\SEO;

trait AppSEORouteCollectionTrait
{
    public function prefixed(): string
    {
        return 'app_seo_' . $this->value;
    }
}
