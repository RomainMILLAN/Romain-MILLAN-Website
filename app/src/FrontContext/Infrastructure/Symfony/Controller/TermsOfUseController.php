<?php

namespace App\FrontContext\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/terms-of-use',
    name: RouteCollection::TERMS_OF_USE->value,
    methods: [Request::METHOD_GET],
)]
class TermsOfUseController extends AbstractController
{

    public function __invoke(): Response
    {
        return $this->render(
            view: 'frontend/pages/terms_of_use.html.twig',
        );
    }

}
