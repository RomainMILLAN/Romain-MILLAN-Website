<?php

namespace App\Infrastructure\Symfony\Webhook\Consumer;

use App\Domain\Messenger\Command\Notification\Notify;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\RemoteEvent\Attribute\AsRemoteEventConsumer;
use Symfony\Component\RemoteEvent\Consumer\ConsumerInterface;
use Symfony\Component\RemoteEvent\RemoteEvent;

#[AsRemoteEventConsumer('notification')]
class NotificationConsumer implements ConsumerInterface
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    public function consume(RemoteEvent $event): void
    {
        if ($event instanceof Notify == false) {
            return;
        }

        $this->commandBus->dispatch($event);

        return;
    }
}
