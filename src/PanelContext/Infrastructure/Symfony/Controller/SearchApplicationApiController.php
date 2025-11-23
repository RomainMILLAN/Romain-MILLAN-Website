<?php

namespace Panel\Infrastructure\Symfony\Controller;

use Panel\Domain\Entity\Application;
use Panel\Infrastructure\Symfony\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/applications/search',
    name: RouteCollection::APPLICATIONS_SEARCH_API->value,
    methods: [Request::METHOD_GET],
)]
class SearchApplicationApiController extends AbstractController
{
    public function __construct(
        private readonly ApplicationRepository $applicationRepository,
    ) {
    }

    public function __invoke(
        #[MapQueryParameter]
        string $query,
    ): Response {
        /** @var Application[] $applications */
        $applications = $this->applicationRepository->searchByName($query)
            ->getQuery()
            ->getResult();

        return $this->render(
            view: 'panel/api/search.html.twig',
            parameters: [
                'applications' => $applications,
            ],
        );
    }
}
