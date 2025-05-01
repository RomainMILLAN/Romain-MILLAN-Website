<?php

declare(strict_types=1);

namespace Panel\Infrastructure\Symfony\Router;

trait AppPanelContextRouteCollectionTrait
{
    public function prefixed(): string
    {
        return 'app_panel_' . $this->value;
    }
}
