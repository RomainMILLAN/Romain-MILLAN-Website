<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\DocTag;

use Panel\Domain\Entity\DocTag;
use Panel\Infrastructure\Symfony\Form\DocTagForm;
use Panel\Infrastructure\Symfony\Repository\DocTagRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/docs/tags/{id}/edit',
    name: RouteCollection::EDIT->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class EditController extends AbstractController
{
    public function __construct(
        private readonly DocTagRepository $docTagRepository,
    ) {
    }

    public function __invoke(
        #[MapEntity(mapping: ['id' => 'id'])]
        DocTag $docTag,
        Request $request,
    ): Response {
        $form = $this->createForm(DocTagForm::class, $docTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->docTagRepository->save($form->getData());

            $this->addFlash(
                type: 'success',
                message: 'Tag édité',
            );

            return $this->redirectToRoute(RouteCollection::LIST->prefixed());
        }

        return $this->render(
            view: 'panel/gestion/doc_tag/edit.html.twig',
            parameters: [
                'form' => $form->createView(),
                'entity' => $docTag,
            ],
        );
    }
}
