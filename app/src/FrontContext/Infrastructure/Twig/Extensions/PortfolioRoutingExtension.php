<?php

namespace App\FrontContext\Infrastructure\Twig\Extensions;

use App\FrontContext\Infrastructure\Symfony\Controller\RouteCollection;
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
        if ($this->requestStack->getMainRequest()->attributes->get(
            '_route'
        ) === RouteCollection::PORTFOLIO->prefixed()) {
            return true;
        }

        return false;
    }
}
