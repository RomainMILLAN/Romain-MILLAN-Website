<?php

declare(strict_types=1);

namespace App\Controller\SEO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/sitemap-projects.xml',
    name: RouteCollection::SITEMAP_PROJECTS,
    format: 'xml',
)]
class SitemapProjectsController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('seo/sitemap/projects.xml.twig');
    }
}
