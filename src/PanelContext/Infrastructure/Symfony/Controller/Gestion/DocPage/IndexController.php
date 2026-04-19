<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\DocPage;

use Panel\Infrastructure\Symfony\Repository\DocPageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/docs',
    name: RouteCollection::INDEX->value,
    methods: [Request::METHOD_GET],
)]
class IndexController extends AbstractController
{
    public function __construct(
        private readonly DocPageRepository $docPageRepository,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render(
            view: 'panel/gestion/doc_page/index.html.twig',
            parameters: [
                'pages' => $this->docPageRepository->findAllOrderedByTitle(),
                'currentPage' => null,
            ],
        );
    }
}
