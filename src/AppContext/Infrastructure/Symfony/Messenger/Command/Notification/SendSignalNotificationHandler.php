<?php

namespace App\Infrastructure\Symfony\Messenger\Command\Notification;

use App\Domain\Messenger\Command\Notification\SendSignalNotification;
use App\Infrastructure\Symfony\Notifier\SignalNotifier;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
class SendSignalNotificationHandler
{
    public function __construct(
        private readonly SignalNotifier $signalNotifier,
    ) {
    }

    public function __invoke(SendSignalNotification $command): void
    {
        $this->signalNotifier->notify($command->notification);
    }
}
