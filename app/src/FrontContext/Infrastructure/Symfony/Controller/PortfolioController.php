<?php

declare(strict_types=1);

namespace App\FrontContext\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/portfolio',
    name: RouteCollection::PORTFOLIO->value,
    methods: ['GET'],
)]
class PortfolioController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('front/portfolio/portfolio.html.twig');
    }
}
