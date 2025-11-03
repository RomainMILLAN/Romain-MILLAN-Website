<?php

namespace App\Infrastructure\Symfony\HttpClient;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

readonly class SignalClient implements ClientInterface
{
    public function __construct(
        private HttpClientInterface $signalClient,
        #[Autowire('%env(SIGNAL_API_URL)%')]
        private string $signalApiUrl,
        #[Autowire('%env(SIGNAL_API_SENDER_NUMBER)%')]
        private string $signalApiSenderNumber,
    ) {
    }

    public function request(string $method, string $uri, array $body, array $options = []): ResponseInterface
    {
        $options = [
            'base_uri' => $this->signalApiUrl,
            ...$options,
            'json' => [
                ...$body,
                'number' => $this->signalApiSenderNumber,
            ],
        ];

        return $this->signalClient->request($method, $uri, $options);
    }
}
