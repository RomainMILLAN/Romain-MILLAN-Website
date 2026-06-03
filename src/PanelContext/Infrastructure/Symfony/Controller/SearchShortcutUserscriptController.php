<?php

namespace Panel\Infrastructure\Symfony\Controller;

use Panel\Infrastructure\Symfony\Security\UserscriptTokenInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/userscript/panel-search-shortcut.user.js',
    name: RouteCollection::USERSCRIPT_SEARCH_SHORTCUT->value,
    methods: [Request::METHOD_GET],
)]
class SearchShortcutUserscriptController extends AbstractController
{
    public function __construct(
        #[Autowire('%env(VERSION)%')]
        private readonly string $appVersion,
        private readonly UserscriptTokenInterface $token,
    ) {
    }

    public function __invoke(
        Request $request,
        #[MapQueryParameter('token')]
        string $candidate = '',
    ): Response {
        if (!$this->token->matches($candidate)) {
            throw new NotFoundHttpException();
        }

        $content = $this->renderView(
            view: 'panel/userscript/panel-search-shortcut.user.js.twig',
            parameters: [
                'panelOrigin' => $request->getSchemeAndHttpHost(),
                'appVersion' => $this->appVersion,
                'token' => $this->token->value(),
            ],
        );

        return new Response(
            content: $content,
            status: Response::HTTP_OK,
            headers: ['Content-Type' => 'application/javascript; charset=utf-8'],
        );
    }
}
