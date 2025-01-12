<?php

namespace App\FrontContext\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[When(env: 'dev')]
#[Route(
    path: '/ui-kit',
    name: RouteCollection::UI->value,
    methods: [Request::METHOD_GET],
)]
class UiKitController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render(
            view: 'frontend/pages/ui.html.twig',
        );
    }
}
