<?php

declare(strict_types=1);

namespace App\AppContext\Infrastructure\Symfony\Controller\SEO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/robots.txt',
    name: RouteCollection::ROBOTS_TXT->value,
    format: 'txt',
)]
class RobotsTxtController extends AbstractController
{
    public function __invoke(string $env): Response
    {
        $disallowedRoutes = ($env !== 'prod')
            ? [
                'app_signature_create' => '',
                'app_panel_dashboard' => '',
                'app_panel_prod_01_uptime_kuma' => '',
                'app_panel_cloud_uptime_robot' => '',
                'app_panel_prod_01_dockge' => '',
                'app_security_login' => '',
                'app_security_logout' => '',
            ]
            : ['*'];

        $disallowedPaths = [];

        $disallowAll = \count($disallowedRoutes) === 1 && '*' === ($disallowedRoutes[0] ?? []);

        return $this->render('seo/robots.txt.twig', [
            'disallowedRoutes' => $disallowedRoutes,
            'disallowedPaths' => $disallowedPaths,
            'disallowAll' => $disallowAll,
        ]);
    }
}
