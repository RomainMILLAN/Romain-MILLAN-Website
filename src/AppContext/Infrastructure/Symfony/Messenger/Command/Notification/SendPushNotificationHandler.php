<?php

namespace App\Infrastructure\Symfony\Messenger\Command\Notification;

use App\Domain\Messenger\Command\Notification\SendPushNotification;
use App\Infrastructure\Symfony\Repository\PushNotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
class SendPushNotificationHandler
{
    public function __construct(
        #[Autowire(env: 'VAPID_PUBLIC_KEY')]
        private string $vapidPublicKey,
        #[Autowire(env: 'VAPID_PRIVATE_KEY')]
        private string $vapidPrivateKey,
        private readonly EntityManagerInterface $entityManager,
        private readonly PushNotificationRepository $pushNotificationRepository,
        private readonly string $defaultUri,
    ) {
    }

    public function __invoke(SendPushNotification $command): void
    {
        foreach ($this->pushNotificationRepository->findAll() as $pushNotification) {
            $subscription = Subscription::create([
                'endpoint' => $pushNotification->endpoint,
                'publicKey' => $pushNotification->p256dh,
                'authToken' => $pushNotification->auth,
            ]);

            $webPush = new WebPush([
                'VAPID' => [
                    'subject' => $this->defaultUri,
                    'publicKey' => $this->vapidPublicKey,
                    'privateKey' => $this->vapidPrivateKey,
                ],
            ]);

            $payload = json_encode($command->notification->toArray());
            try {
                $result = $webPush->sendOneNotification(
                    subscription: $subscription,
                    payload: json_encode($command->notification->toArray())
                );
            } catch (\Throwable $exception) {
                $this->entityManager->remove(
                    $this->pushNotificationRepository->find(
                        id: $pushNotification->getId(),
                    ),
                );
            }
        }
    }
}
