<?php

namespace App\Domain\Messenger\Command\Notification;

class RegisterPushNotification
{
    public function __construct(
        public string $endpoint,
        public string $p256dh,
        public string $auth,
    ) {
    }
}
