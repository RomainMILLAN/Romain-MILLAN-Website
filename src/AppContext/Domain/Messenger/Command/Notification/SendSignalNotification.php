<?php

namespace App\Domain\Messenger\Command\Notification;

use App\Domain\Model\Notification\Notification;

class SendSignalNotification
{
    public function __construct(
        public Notification $notification,
    ) {
    }
}
