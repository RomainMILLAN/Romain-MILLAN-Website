<?php

namespace App\Controller;

use App\Controller\Portfolio\RouteCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RedirectController extends AbstractController
{
    public function redirectToLocale(): Response
    {
        return $this->redirectToRoute(RouteCollection::HOMEPAGE->prefixed());
    }
}