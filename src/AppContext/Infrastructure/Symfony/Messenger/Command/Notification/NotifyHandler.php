<?php

namespace App\Infrastructure\Symfony\Messenger\Command\Notification;

use App\Domain\Messenger\Command\Notification\Notify;
use App\Domain\Model\Notification\Notification;
use App\Infrastructure\Symfony\Notifier\SignalNotifier;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
class NotifyHandler
{
    public function __construct(
        private readonly SignalNotifier $signalNotifier,
    ) {
    }

    public function __invoke(Notify $command): void
    {
        $message = $command->getPayload()['message'];

        if ($message == null) {
            return;
        }

        $notification = new Notification(body: $message);

        $this->signalNotifier->notify($notification);
    }
}
