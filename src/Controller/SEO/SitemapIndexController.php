<?php

declare(strict_types=1);

namespace App\Controller\SEO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/sitemap-index.xml',
    name: RouteCollection::SITEMAP_INDEX,
    format: 'xml',
)]
class SitemapIndexController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('seo/sitemap/index.xml.twig');
    }
}
