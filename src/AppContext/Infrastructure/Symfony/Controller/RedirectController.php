<?php

namespace App\Infrastructure\Symfony\Controller;

use Front\Infrastructure\Symfony\Controller\RouteCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RedirectController extends AbstractController
{
    public function redirectToLocale(): Response
    {
        return $this->redirectToRoute(RouteCollection::PORTFOLIO->prefixed());
    }
}
