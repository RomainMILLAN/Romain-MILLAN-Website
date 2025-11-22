<?php

namespace App\Infrastructure\Symfony\Command;

use App\Domain\Messenger\Command\Notification\SendPushNotification;
use App\Domain\Model\Notification\Notification;
use App\Infrastructure\Symfony\Notifier\SignalNotifier;
use App\Infrastructure\Symfony\Repository\PushNotificationRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsCommand(
    name: 'app:notification:test',
)]
class TestNotificationCommand extends Command
{
    public function __construct(
        private readonly SignalNotifier $signalNotifier,
        private readonly PushNotificationRepository $pushNotificationRepository,
        private readonly TranslatorInterface $translator,
        private readonly MessageBusInterface $messageBus,
        private readonly string $defaultUri,
        #[Autowire(env: 'VAPID_PUBLIC_KEY')]
        private string $vapidPublicKey,
        #[Autowire(env: 'VAPID_PRIVATE_KEY')]
        private string $vapidPrivateKey,
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $this->messageBus->dispatch(
            new SendPushNotification(
                notification: new Notification(
                    body: 'Test de notification',
                    title: 'RomainMILLAN/Panel',
                ),
            ),
        );

        $style->success('Notification test send');

        return self::SUCCESS;
    }
}
