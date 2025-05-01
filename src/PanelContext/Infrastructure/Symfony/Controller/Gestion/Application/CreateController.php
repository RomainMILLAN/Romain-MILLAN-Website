<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\Application;

use Panel\Domain\Entity\Application;
use Panel\Infrastructure\Symfony\Form\ApplicationForm;
use Panel\Infrastructure\Symfony\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/application/create',
    name: RouteCollection::CREATE->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly ApplicationRepository $applicationRepository,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $form = $this->createForm(ApplicationForm::class, new Application());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applicationRepository->save($form->getData());

            $this->addFlash(
                type: 'success',
                message: 'Application enregistrée'
            );

            return $this->redirectToRoute(RouteCollection::LIST->prefixed());
        }

        return $this->render(
            view: 'panel/gestion/application/create.html.twig',
            parameters: [
                'form' => $form->createView(),
            ],
        );
    }
}
