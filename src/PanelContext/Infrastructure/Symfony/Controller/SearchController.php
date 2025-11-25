<?php

namespace Panel\Infrastructure\Symfony\Controller;

use Panel\Infrastructure\Symfony\Form\SearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/search',
    name: RouteCollection::SEARCH->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class SearchController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        if ($this->getUser() == null) {
            return $this->redirect('https://duckduckgo.com/');
        }

        $form = $this->createForm(SearchForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $query = $form->get('query')
                ->getData();

            return new RedirectResponse(
                url: \sprintf('https://duckduckgo.com/?q=%s', $query),
            );
        }

        return $this->render(
            view: 'panel/search.html.twig',
            parameters: [
                'form' => $form->createView(),
            ],
        );
    }
}
