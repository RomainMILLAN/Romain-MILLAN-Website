<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\Application;

use Panel\Infrastructure\Symfony\Form\Filter\ApplicationFilterForm;
use Panel\Infrastructure\Symfony\Repository\ApplicationRepository;
use Spiriit\Bundle\FormFilterBundle\Filter\FilterBuilderUpdater;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/applications',
    name: RouteCollection::LIST->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class ListController extends AbstractController
{
    public function __construct(
        private readonly ApplicationRepository $applicationRepository,
        private readonly FilterBuilderUpdater $filterBuilderUpdater,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $filterForm = $this->createForm(ApplicationFilterForm::class);
        $filterForm->handleRequest($request);

        $queryBuilder = $this->applicationRepository->getListQueryBuilder();
        $this->filterBuilderUpdater->addFilterConditions($filterForm, $queryBuilder);

        return $this->render(
            view: 'panel/gestion/application/list.html.twig',
            parameters: [
                'applications' => $queryBuilder->getQuery()
                    ->getResult(),
                'filterForm' => $filterForm->createView(),
            ],
        );
    }
}
