<?php

namespace App\Infrastructure\Symfony\Controller;

use Front\Infrastructure\Symfony\Controller\RouteCollection;
use Security\Infrastructure\Symfony\Controller\RouteCollection as SecurityRouteCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RedirectController extends AbstractController
{
    public function redirectToLocale(): Response
    {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute(SecurityRouteCollection::LOGIN->prefixed());
        }

        return $this->redirectToRoute(RouteCollection::PORTFOLIO->prefixed());
    }
}
