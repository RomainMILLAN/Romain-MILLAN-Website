<?php

declare(strict_types=1);

namespace App\Controller;

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
        dd("Hello World");
        return $this->redirectToRoute(\App\Controller\Portfolio\RouteCollection::PORTFOLIO->prefixed());
    }
}
