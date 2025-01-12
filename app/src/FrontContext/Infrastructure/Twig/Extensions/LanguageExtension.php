<?php

namespace App\FrontContext\Infrastructure\Twig\Extensions;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LanguageExtension extends AbstractExtension
{
    public function __construct(
        private readonly RequestStack $requestStack
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_current_language', [$this, 'isCurrentLanguage']),
        ];
    }

    public function isCurrentLanguage(string $languageCode): bool
    {
        if ($this->requestStack->getCurrentRequest()->getLocale() === mb_strtolower($languageCode)) {
            return true;
        }

        return false;
    }
}
