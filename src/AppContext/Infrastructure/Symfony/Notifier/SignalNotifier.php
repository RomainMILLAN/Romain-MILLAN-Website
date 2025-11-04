<?php

namespace App\Infrastructure\Symfony\Notifier;

use App\Domain\Model\Notification\Notification;
use App\Infrastructure\Symfony\HttpClient\SignalClient;
use App\Infrastructure\Symfony\Notifier\Contracts\SignalNotifierInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;

class SignalNotifier implements SignalNotifierInterface
{
    public const string SIGNAL_SEND_MESSAGE_URI = '/v2/send';

    public function __construct(
        private readonly SignalClient $client,
        #[Autowire(env: 'SIGNAL_NOTIFICATION_NUMBER')]
        private readonly string $signalPhoneNumber,
    ) {
    }

    public function notify(Notification $notification): void
    {
        if (empty($this->signalPhoneNumber) == false) {
            $this->client->request(
                method: Request::METHOD_POST,
                uri: self::SIGNAL_SEND_MESSAGE_URI,
                body: [
                    'message' => $notification->body,
                    'recipients' => [$this->signalPhoneNumber],
                ],
            );
        }
    }
}
