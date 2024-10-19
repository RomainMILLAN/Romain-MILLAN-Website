<?php

namespace App\SecurityContext\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(
    path: '/login',
    name: RouteCollection::LOGIN->value,
)]
class LoginController extends AbstractController
{
    public function __invoke(
        AuthenticationUtils $authenticationUtils,
    ): Response {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute(
                \App\FrontContext\Infrastructure\Symfony\Controller\RouteCollection::HOMEPAGE->prefixed()
            );
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
