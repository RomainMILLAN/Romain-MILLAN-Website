<?php

namespace Panel\Infrastructure\Symfony\Security;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

use function Symfony\Component\String\u;

final class UserscriptToken implements UserscriptTokenInterface
{
    public function __construct(
        #[Autowire('%env(USERSCRIPT_TOKEN)%')]
        private readonly string $token,
    ) {
    }

    public function isConfigured(): bool
    {
        return !u($this->token)->isEmpty();
    }

    public function matches(string $candidate): bool
    {
        // Jeton non configuré ⇒ jamais valide (fail closed). Comparaison timing-safe.
        return $this->isConfigured() && hash_equals($this->token, $candidate);
    }

    public function value(): string
    {
        return $this->token;
    }
}
