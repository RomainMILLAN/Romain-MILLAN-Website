<?php

namespace Panel\Infrastructure\Symfony\Controller;

use Panel\Infrastructure\Symfony\Security\UserscriptTokenInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/help/search-shortcut',
    name: RouteCollection::HELP_SEARCH_SHORTCUT->value,
    methods: [Request::METHOD_GET],
)]
class HelpSearchShortcutController extends AbstractController
{
    public function __construct(
        private readonly UserscriptTokenInterface $token,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render(
            view: 'panel/help/search_shortcut.html.twig',
            parameters: [
                'userscriptToken' => $this->token->value(),
                'userscriptTokenConfigured' => $this->token->isConfigured(),
            ],
        );
    }
}
