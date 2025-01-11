<?php

namespace App\PanelContext\Infrastructure\UptimeKuma;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

readonly class UptimeKumaClient
{
    public function __construct(
        private HttpClientInterface $client,
        #[Autowire(env: 'UPTIME_KUMA_API_BASE_URL')]
        private string $uptimeKumaBaseUrl,
        #[Autowire(env: 'UPTIME_KUMA_API_KEY')]
        private string $uptimeKumaApiKey,
    ) {
    }

    /**
     * @param array<mixed> $options
     */
    public function request(string $uri, string $method = Request::METHOD_GET, array $options = []): ResponseInterface
    {
        return $this->client->request(
            method: $method,
            url: sprintf('%s/%s', $this->uptimeKumaBaseUrl, $uri),
            options: array_merge(
                [
                    'auth_basic' => [
                        '',
                        $this->uptimeKumaApiKey,
                    ],
                ],
                $options,
            ),
        );
    }
}
