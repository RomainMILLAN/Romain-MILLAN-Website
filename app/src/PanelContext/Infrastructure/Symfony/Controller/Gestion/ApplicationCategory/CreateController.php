<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\ApplicationCategory;

use Panel\Domain\Entity\ApplicationCategory;
use Panel\Infrastructure\Symfony\Form\ApplicationCategoryForm;
use Panel\Infrastructure\Symfony\Repository\ApplicationCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/applications/category/create',
    name: RouteCollection::CREATE->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly ApplicationCategoryRepository $repository,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $form = $this->createForm(ApplicationCategoryForm::class, new ApplicationCategory());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($form->getData());

            $this->addFlash(
                type: 'success',
                message: 'Catégorie enregistrée'
            );

            return $this->redirectToRoute(RouteCollection::LIST->prefixed());
        }

        return $this->render(
            view: 'panel/gestion/applicationCategory/create.html.twig',
            parameters: [
                'form' => $form->createView(),
            ],
        );
    }
}
