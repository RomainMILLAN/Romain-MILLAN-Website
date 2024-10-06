<?php

declare(strict_types=1);

namespace App\Controller\SEO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/sitemap-pages.xml',
    name: RouteCollection::SITEMAP_PAGES,
    format: 'xml',
)]
class SitemapPagesController extends AbstractController
{
    public function __invoke(): Response
    {
        $pageRoutes = [
            \App\Controller\Portfolio\RouteCollection::HOMEPAGE->prefixed(),
            \App\Controller\Portfolio\RouteCollection::PORTFOLIO->prefixed(),
        ];

        return $this->render('seo/sitemap/pages.xml.twig', [
            'pageRoutes' => $pageRoutes,
        ]);
    }
}
