<?php

namespace App\Domain\Messenger\Command\Notification;

use App\Domain\Model\Notification\Notification;

class SendPushNotification
{
    public function __construct(
        public Notification $notification,
    ) {
    }
}
