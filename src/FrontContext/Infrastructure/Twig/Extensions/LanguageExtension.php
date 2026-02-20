<?php

namespace Front\Infrastructure\Twig\Extensions;

use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LanguageExtension extends AbstractExtension
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly RequestAnalyzerInterface $requestAnalyzer,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_current_language', [$this, 'isCurrentLanguage']),
            new TwigFunction('sulu_localizations', [$this, 'getLocalizations']),
        ];
    }

    public function isCurrentLanguage(string $languageCode): bool
    {
        return $this->requestStack->getCurrentRequest()->getLocale() === mb_strtolower($languageCode);
    }

    /**
     * @return array<array{locale: string, language: string, current: bool}>
     */
    public function getLocalizations(): array
    {
        $webspace = $this->requestAnalyzer->getWebspace();
        if (null === $webspace) {
            return [];
        }

        $currentLocale = $this->requestStack->getCurrentRequest()->getLocale();

        $localizations = [];
        foreach ($webspace->getLocalizations() as $localization) {
            $localizations[] = [
                'locale' => $localization->getLocale(),
                'language' => $localization->getLanguage(),
                'current' => $localization->getLocale() === $currentLocale,
            ];
        }

        return $localizations;
    }
}
