<?php

declare(strict_types=1);

namespace App\FrontContext\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/',
    name: RouteCollection::HOMEPAGE->value,
    methods: ['GET'],
)]
class HomepageController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->redirectToRoute(RouteCollection::PORTFOLIO->prefixed());
    }
}
