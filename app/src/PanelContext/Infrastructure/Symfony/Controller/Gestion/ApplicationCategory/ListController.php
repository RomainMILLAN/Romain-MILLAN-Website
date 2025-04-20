<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\ApplicationCategory;

use Panel\Infrastructure\Symfony\Repository\ApplicationCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/applications/categories',
    name: RouteCollection::LIST->value,
    methods: [Request::METHOD_GET],
)]
class ListController extends AbstractController
{

    public function __construct(
        private readonly ApplicationCategoryRepository $applicationCategoryRepository,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render(
            view: 'panel/gestion/applicationCategory/list.html.twig',
            parameters: [
                'categories' => $this->applicationCategoryRepository->findAll(),
            ],
        );
    }

}
