<?php

namespace Panel\Infrastructure\Symfony\Controller;

use Panel\Infrastructure\Symfony\Repository\ApplicationCategoryRepository;
use Panel\Infrastructure\Symfony\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/',
    name: RouteCollection::DASHBOARD->value,
    methods: [Request::METHOD_GET],
)]
class DashboardController extends AbstractController
{
    public function __construct(
        private readonly ApplicationRepository $applicationRepository,
        private readonly ApplicationCategoryRepository $applicationCategoryRepository,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render(
            view: 'panel/dashboard.html.twig',
            parameters: [
                'applications' => $this->applicationRepository->findAll(),
                'dashboardCategories' => $this->applicationCategoryRepository->findBy([
                    'inAccordion' => false,
                ], [
                    'orderNumber' => 'ASC',
                ]),
                'accordionCategories' => $this->applicationCategoryRepository->findBy([
                    'inAccordion' => true,
                ], [
                    'orderNumber' => 'ASC',
                ]),
            ],
        );
    }
}
