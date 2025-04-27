<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\Application;

use Panel\Infrastructure\Symfony\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/applications',
    name: RouteCollection::LIST->value,
    methods: [Request::METHOD_GET],
)]
class ListController extends AbstractController
{
    public function __construct(
        private readonly ApplicationRepository $applicationRepository,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render(
            view: 'panel/gestion/application/list.html.twig',
            parameters: [
                'applications' => $this->applicationRepository->findAll(),
            ],
        );
    }
}
