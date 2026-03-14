<?php

namespace Front\Infrastructure\Twig\Extensions;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PortfolioRoutingExtension extends AbstractExtension
{
    public function __construct(
        private readonly RequestStack $requestStack
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_current_portfolio', [$this, 'isCurrentPortfolio']),
        ];
    }

    public function isCurrentPortfolio(): bool
    {
        $pathInfo = $this->requestStack->getMainRequest()?->getPathInfo() ?? '';

        return (bool) preg_match('#^/[a-z]{2}/portfolio$#', $pathInfo);
    }
}
