<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\DocPage;

use Panel\Domain\Entity\DocPage;
use Panel\Infrastructure\Symfony\Repository\DocPageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/docs/search',
    name: RouteCollection::SEARCH_API->value,
    methods: [Request::METHOD_GET],
)]
class SearchApiController extends AbstractController
{
    public function __construct(
        private readonly DocPageRepository $docPageRepository,
    ) {
    }

    public function __invoke(
        #[MapQueryParameter]
        string $query,
    ): Response {
        /** @var DocPage[] $pages */
        $pages = $this->docPageRepository->searchByTitleOrContent($query)
            ->getQuery()
            ->getResult();

        return $this->render(
            view: 'panel/gestion/doc_page/_search_results.html.twig',
            parameters: [
                'pages' => $pages,
            ],
        );
    }
}
