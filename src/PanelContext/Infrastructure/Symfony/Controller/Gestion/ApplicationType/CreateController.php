<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\ApplicationType;

use Panel\Domain\Entity\ApplicationType;
use Panel\Infrastructure\Symfony\Form\ApplicationTypeForm;
use Panel\Infrastructure\Symfony\Repository\ApplicationTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/application/type/create',
    name: RouteCollection::CREATE->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly ApplicationTypeRepository $applicationTypeRepository,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $form = $this->createForm(ApplicationTypeForm::class, new ApplicationType());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applicationTypeRepository->save($form->getData());

            $this->addFlash(
                type: 'success',
                message: 'Création du type',
            );

            return $this->redirectToRoute(RouteCollection::LIST->prefixed());
        }

        return $this->render(
            view: 'panel/gestion/applicationType/create.html.twig',
            parameters: [
                'form' => $form->createView(),
            ],
        );
    }
}
