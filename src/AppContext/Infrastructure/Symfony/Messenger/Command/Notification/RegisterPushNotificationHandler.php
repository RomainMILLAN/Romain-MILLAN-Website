<?php

namespace App\Infrastructure\Symfony\Messenger\Command\Notification;

use App\Domain\Entity\PushNotification;
use App\Domain\Messenger\Command\Notification\RegisterPushNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class RegisterPushNotificationHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(RegisterPushNotification $command): void
    {
        $pushNotification = new PushNotification(
            endpoint: $command->endpoint,
            p256dh: $command->p256dh,
            auth: $command->auth,
        );

        $this->entityManager->persist($pushNotification);
        $this->entityManager->flush();
    }
}
