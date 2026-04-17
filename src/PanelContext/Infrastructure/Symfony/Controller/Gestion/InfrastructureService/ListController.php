<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\InfrastructureService;

use Panel\Infrastructure\Symfony\Form\Filter\InfrastructureServiceFilterForm;
use Panel\Infrastructure\Symfony\Repository\InfrastructureServiceRepository;
use Spiriit\Bundle\FormFilterBundle\Filter\FilterBuilderUpdater;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/infrastructure-services',
    name: RouteCollection::LIST->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class ListController extends AbstractController
{
    public function __construct(
        private readonly InfrastructureServiceRepository $infrastructureServiceRepository,
        private readonly FilterBuilderUpdater $filterBuilderUpdater,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $filterForm = $this->createForm(InfrastructureServiceFilterForm::class);
        $filterForm->handleRequest($request);

        $queryBuilder = $this->infrastructureServiceRepository->getListQueryBuilder();
        $this->filterBuilderUpdater->addFilterConditions($filterForm, $queryBuilder);

        return $this->render(
            view: 'panel/gestion/infrastructure-service/list.html.twig',
            parameters: [
                'infrastructureServices' => $queryBuilder->getQuery()
                    ->getResult(),
                'filterForm' => $filterForm->createView(),
            ],
        );
    }
}
