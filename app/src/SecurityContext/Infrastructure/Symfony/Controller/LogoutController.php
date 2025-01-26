<?php

namespace Security\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/logout',
    name: RouteCollection::LOGOUT->value,
    methods: [Request::METHOD_GET],
)]
class LogoutController extends AbstractController
{
    public function __invoke(): Response
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
