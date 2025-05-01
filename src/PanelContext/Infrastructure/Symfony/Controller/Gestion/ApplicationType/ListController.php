<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\ApplicationType;

use Panel\Infrastructure\Symfony\Repository\ApplicationTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/applications/types',
    name: RouteCollection::LIST->value,
    methods: [Request::METHOD_GET],
)]
class ListController extends AbstractController
{
    public function __construct(
        private readonly ApplicationTypeRepository $applicationTypeRepository,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render(
            view: 'panel/gestion/applicationType/list.html.twig',
            parameters: [
                'types' => $this->applicationTypeRepository->findAll(),
            ],
        );
    }
}
