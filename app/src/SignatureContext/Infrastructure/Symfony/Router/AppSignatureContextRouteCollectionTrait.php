<?php

declare(strict_types=1);

namespace App\SignatureContext\Infrastructure\Symfony\Router;

trait AppSignatureContextRouteCollectionTrait
{
    public function prefixed(): string
    {
        return 'app_signature_' . $this->value;
    }
}