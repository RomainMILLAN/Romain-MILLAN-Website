<?php

namespace App\Infrastructure\Symfony\HttpClient;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ClientInterface
{
    public function request(string $method, string $uri, array $body, array $options = []): ResponseInterface;
}
