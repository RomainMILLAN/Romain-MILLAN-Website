<?php

namespace Panel\Infrastructure\Twig\Extensions;

use Panel\Domain\Entity\Application;
use Panel\Infrastructure\Symfony\Repository\ApplicationRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ServicesExtension extends AbstractExtension
{
    public function __construct(
        private readonly ApplicationRepository $applicationRepository,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('services_has_interfaces', fn () => $this->getServicesHasInterfaces()),
        ];
    }

    /**
     * @return array<int,Application>
     */
    private function getServicesHasInterfaces(): array
    {
        return $this->applicationRepository->findBy([
            'hasInterface' => true,
        ]);
    }
}
