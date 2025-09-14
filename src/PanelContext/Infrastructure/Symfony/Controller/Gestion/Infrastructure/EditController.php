<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\Infrastructure;

use Panel\Infrastructure\Symfony\Form\InfrastructureForm;
use Panel\Infrastructure\Symfony\Repository\Custom\InfrastructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/infrastructure/edit',
    name: RouteCollection::EDIT->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class EditController extends AbstractController
{
    public function __construct(
        private readonly InfrastructureRepository $infrastructureRepository,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $form = $this->createForm(InfrastructureForm::class, [
            'content' => $this->infrastructureRepository->get(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->infrastructureRepository->save(
                content: $form->get('content')
                    ->getData(),
            );

            $this->addFlash(
                type: 'success',
                message: 'Infrastructure enregistrée',
            );

            return $this->redirectToRoute(
                route: RouteCollection::EDIT->prefixed(),
            );
        }

        return $this->render(
            view: 'panel/gestion/infrastructure/edit.html.twig',
            parameters: [
                'form' => $form->createView(),
            ],
        );
    }
}
