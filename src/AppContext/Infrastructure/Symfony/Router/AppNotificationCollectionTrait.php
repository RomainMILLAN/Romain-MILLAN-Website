<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Router;

trait AppNotificationCollectionTrait
{
    public function prefixed(): string
    {
        return 'app_notification_' . $this->value;
    }
}
