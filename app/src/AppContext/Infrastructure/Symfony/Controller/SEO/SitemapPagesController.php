<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\SEO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/sitemap-pages.xml',
    name: RouteCollection::SITEMAP_PAGES->value,
    format: 'xml',
)]
class SitemapPagesController extends AbstractController
{
    public function __invoke(): Response
    {
        $pageRoutes = [
            \Front\Infrastructure\Symfony\Controller\RouteCollection::PORTFOLIO->prefixed(),
            \Front\Infrastructure\Symfony\Controller\RouteCollection::TERMS_OF_USE->prefixed(),
        ];

        return $this->render('seo/sitemap/pages.xml.twig', [
            'pageRoutes' => $pageRoutes,
        ]);
    }
}
