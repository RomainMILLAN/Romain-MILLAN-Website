<?php

declare(strict_types=1);

namespace App\Controller\SEO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/robots.txt',
    name: RouteCollection::ROBOTS_TXT,
    format: 'txt',
)]
class RobotsTxtController extends AbstractController
{
    public function __invoke(string $env): Response
    {
        $disallowedRoutes = ($env === 'prod')
            ? []
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
