<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\DocTag;

use Panel\Domain\Entity\DocTag;
use Panel\Infrastructure\Symfony\Form\DocTagForm;
use Panel\Infrastructure\Symfony\Repository\DocTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/docs/tags/create',
    name: RouteCollection::CREATE->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly DocTagRepository $docTagRepository,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $form = $this->createForm(DocTagForm::class, new DocTag());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->docTagRepository->save($form->getData());

            $this->addFlash(
                type: 'success',
                message: 'Tag enregistré',
            );

            return $this->redirectToRoute(RouteCollection::LIST->prefixed());
        }

        return $this->render(
            view: 'panel/gestion/doc_tag/create.html.twig',
            parameters: [
                'form' => $form->createView(),
            ],
        );
    }
}
