<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\DocPage;

use Panel\Domain\Entity\DocPage;
use Panel\Infrastructure\Symfony\Repository\DocPageRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/docs/{slug}',
    name: RouteCollection::SHOW->value,
    requirements: ['slug' => '[a-z0-9][a-z0-9-]*'],
    methods: [Request::METHOD_GET],
    priority: -10,
)]
class ShowController extends AbstractController
{
    public function __construct(
        private readonly DocPageRepository $docPageRepository,
    ) {
    }

    public function __invoke(
        #[MapEntity(mapping: ['slug' => 'slug'])]
        DocPage $docPage,
    ): Response {
        return $this->render(
            view: 'panel/gestion/doc_page/index.html.twig',
            parameters: [
                'pages' => $this->docPageRepository->findAllOrderedByTitle(),
                'currentPage' => $docPage,
            ],
        );
    }
}
