<?php

namespace Panel\Infrastructure\Twig\Extensions;

use Panel\Domain\Entity\Application;
use Panel\Infrastructure\Symfony\Controller\RouteCollection;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Attribute\AsTwigFunction;

class ApplicationExtension
{
    public function __construct(
        private readonly RouterInterface $router,
    ) {
    }

    #[AsTwigFunction('application_primary_url')]
    public function getPrimaryUrl(Application $application): string
    {
        if ($application->hasInterface) {
            return $this->router->generate(RouteCollection::APPLICATION_INTERFACE->prefixed(), [
                'id' => $application->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        return $application->url;
    }

    #[AsTwigFunction('application_primary_url_target')]
    public function getPrimaryUrlTargetType(Application $application): string
    {
        if ($application->hasInterface) {
            return '_self';
        }

        return '_blank';
    }
}
