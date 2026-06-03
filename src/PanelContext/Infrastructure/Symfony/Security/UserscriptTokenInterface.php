<?php

namespace Panel\Infrastructure\Symfony\Security;

interface UserscriptTokenInterface
{
    public function isConfigured(): bool;

    public function matches(string $candidate): bool;

    public function value(): string;
}
