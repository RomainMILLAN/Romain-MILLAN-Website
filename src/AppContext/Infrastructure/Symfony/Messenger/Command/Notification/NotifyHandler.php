<?php

namespace App\Infrastructure\Symfony\Messenger\Command\Notification;

use App\Domain\Messenger\Command\Notification\Notify;
use App\Domain\Messenger\Command\Notification\SendPushNotification;
use App\Domain\Messenger\Command\Notification\SendSignalNotification;
use App\Domain\Model\Notification\Notification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler()]
class NotifyHandler
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    public function __invoke(Notify $command): void
    {
        $message = $command->getPayload()['message'];

        if ($message == null) {
            return;
        }

        $notification = new Notification(body: $message);

        try {
            $this->commandBus->dispatch(
                new SendSignalNotification($notification),
            );
        } catch (HandlerFailedException $e) {
        }

        try {
            $this->commandBus->dispatch(
                new SendPushNotification($notification),
            );
        } catch (HandlerFailedException $e) {
        }

        return;
    }
}
