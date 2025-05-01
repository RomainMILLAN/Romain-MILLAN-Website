<?php

namespace Panel\Infrastructure\Symfony\Controller;

use Panel\Domain\Entity\Application;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/application/{id}/interface',
    name: RouteCollection::APPLICATION_INTERFACE->value,
    methods: [Request::METHOD_GET],
)]
class ApplicationInterfaceController extends AbstractController
{
    public function __invoke(
        #[MapEntity(mapping: [
            'id' => 'id',
        ])]
        Application $application,
    ): Response {
        return $this->render(
            view: 'panel/service.html.twig',
            parameters: [
                'link' => $application->url,
                'title' => $application->name,
            ],
        );
    }
}
