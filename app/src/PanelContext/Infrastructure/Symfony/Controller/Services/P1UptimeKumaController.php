<?php

namespace Panel\Infrastructure\Symfony\Controller\Services;

use Panel\Infrastructure\Symfony\Controller\RouteCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/service/prod01/uptime_kuma',
    name: RouteCollection::SERVICE_PROD_01_UPTIME_KUMA->value,
    methods: [Request::METHOD_GET],
)]
class P1UptimeKumaController extends AbstractController
{
    public function __invoke(
        #[Autowire('%env(P1_UPTIME_KUMA_IFRAME_LINK)%')]
        string $link,
    ): Response {
        return $this->render(
            view: 'panel/service.html.twig',
            parameters: [
                'link' => $link,
                'title' => 'Uptime Kuma',
            ]
        );
    }
}
