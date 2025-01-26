<?php

namespace Panel\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/p01-dockge',
    name: RouteCollection::PROD_01_DOCKGE->value,
    methods: [Request::METHOD_GET],
)]
class P1DockgeController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render(
            view: 'panel/prod_01_dockge.html.twig',
        );
    }
}
