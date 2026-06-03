<?php

namespace Panel\Tests\Infrastructure\Symfony\Security;

use Panel\Infrastructure\Symfony\Security\UserscriptToken;
use PHPUnit\Framework\TestCase;

final class UserscriptTokenTest extends TestCase
{
    public function test_an_empty_token_is_never_configured(): void
    {
        self::assertFalse((new UserscriptToken(''))->isConfigured());
    }

    public function test_an_empty_token_never_authorizes(): void
    {
        // Fail closed : un jeton non configuré ne valide rien, pas même la chaîne vide.
        self::assertFalse((new UserscriptToken(''))->matches(''));
        self::assertFalse((new UserscriptToken(''))->matches('anything'));
    }

    public function test_a_wrong_candidate_is_rejected(): void
    {
        self::assertFalse((new UserscriptToken('secret'))->matches('wrong'));
        self::assertFalse((new UserscriptToken('secret'))->matches(''));
        self::assertFalse((new UserscriptToken('secret'))->matches('Secret'));
    }

    public function test_the_exact_token_is_accepted(): void
    {
        $token = new UserscriptToken('s3cr3t-token');

        self::assertTrue($token->isConfigured());
        self::assertTrue($token->matches('s3cr3t-token'));
    }
}
