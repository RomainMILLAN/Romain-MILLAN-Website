<?php

namespace App\Infrastructure\Symfony\Notifier\Contracts;

use App\Domain\Model\Notification\Notification;

interface SignalNotifierInterface
{
    public function notify(Notification $notification): void;
}
