<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\InfrastructureService;

use Panel\Domain\Entity\InfrastructureService;
use Panel\Infrastructure\Symfony\Form\InfrastructureServiceForm;
use Panel\Infrastructure\Symfony\Repository\InfrastructureServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/infrastructure-service/create',
    name: RouteCollection::CREATE->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly InfrastructureServiceRepository $infrastructureServiceRepository,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $form = $this->createForm(InfrastructureServiceForm::class, new InfrastructureService());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->infrastructureServiceRepository->save($form->getData());

            $this->addFlash(
                type: 'success',
                message: 'Service d\'infrastructure enregistré'
            );

            return $this->redirectToRoute(RouteCollection::LIST->prefixed());
        }

        return $this->render(
            view: 'panel/gestion/infrastructure-service/create.html.twig',
            parameters: [
                'form' => $form->createView(),
            ],
        );
    }
}
