<?php

namespace Panel\Infrastructure\Symfony\Controller;

use Panel\Infrastructure\Symfony\Repository\Custom\InfrastructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/infrastructure',
    name: RouteCollection::INFRASTRUCTURE->value,
    methods: [Request::METHOD_GET],
)]
class InfrastructureController extends AbstractController
{
    public function __construct(
        private readonly InfrastructureRepository $infrastructureRepository,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render(
            view: 'panel/infrastructure.html.twig',
            parameters: [
                'content' => $this->infrastructureRepository->get(),
            ],
        );
    }
}
