<?php

namespace App\PanelContext\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/p01-uptime-kuma',
    name: RouteCollection::PROD_01_UPTIME_KUMA->value,
    methods: [Request::METHOD_GET],
)]
class P1UptimeKumaController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render(
            view: 'panel/prod_01_uptime_kuma.html.twig',
        );
    }
}
