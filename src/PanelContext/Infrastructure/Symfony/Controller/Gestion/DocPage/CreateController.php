<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\DocPage;

use Panel\Domain\Entity\DocPage;
use Panel\Infrastructure\Symfony\Form\DocPageForm;
use Panel\Infrastructure\Symfony\Repository\DocPageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/docs/create',
    name: RouteCollection::CREATE->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly DocPageRepository $docPageRepository,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $page = new DocPage();
        $form = $this->createForm(DocPageForm::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->docPageRepository->save($page);

            $this->addFlash(
                type: 'success',
                message: 'Page de documentation créée',
            );

            return $this->redirectToRoute(
                route: RouteCollection::SHOW->prefixed(),
                parameters: ['slug' => $page->slug],
            );
        }

        return $this->render(
            view: 'panel/gestion/doc_page/create.html.twig',
            parameters: [
                'form' => $form->createView(),
            ],
        );
    }
}
