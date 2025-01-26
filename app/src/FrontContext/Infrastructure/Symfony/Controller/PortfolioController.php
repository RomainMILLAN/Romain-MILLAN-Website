<?php

namespace Front\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/portfolio',
    name: RouteCollection::PORTFOLIO->value,
    methods: [Request::METHOD_GET]
)]
class PortfolioController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render(
            view: 'frontend/pages/portfolio.html.twig',
        );
    }
}
