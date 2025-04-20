<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\ApplicationCategory;

use Panel\Domain\Entity\ApplicationCategory;
use Panel\Infrastructure\Symfony\Form\ApplicationCategoryForm;
use Panel\Infrastructure\Symfony\Repository\ApplicationCategoryRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/applications/category/{id}/edit',
    name: RouteCollection::EDIT->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class EditController extends AbstractController
{

    public function __construct(
        private readonly ApplicationCategoryRepository $repository,
    ) {
    }

    public function __invoke(
        Request $request,
        #[MapEntity(mapping: ['id' => 'id'])] ApplicationCategory $entity,
    ): Response {
        $form = $this->createForm(ApplicationCategoryForm::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($entity);

            $this->addFlash(
                type: 'success',
                message: 'Catégorie éditée',
            );

            return $this->redirectToRoute(RouteCollection::LIST->prefixed());
        }

        return $this->render(
            view: 'panel/gestion/applicationCategory/edit.html.twig',
            parameters: [
                'form' => $form->createView(),
                'entity' => $entity,
            ],
        );
    }

}
