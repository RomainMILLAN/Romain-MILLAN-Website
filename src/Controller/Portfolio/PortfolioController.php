<?php

declare(strict_types=1);

namespace App\Controller\Portfolio;

use App\Controller\Portfolio\RouteCollection;
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
        return $this->render('portfolio/portfolio.html.twig');
    }
}
