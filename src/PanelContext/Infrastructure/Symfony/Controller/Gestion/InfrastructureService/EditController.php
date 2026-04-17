<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\InfrastructureService;

use Panel\Domain\Entity\InfrastructureService;
use Panel\Infrastructure\Symfony\Form\InfrastructureServiceForm;
use Panel\Infrastructure\Symfony\Repository\InfrastructureServiceRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/infrastructure-service/{id}/edit',
    name: RouteCollection::EDIT->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class EditController extends AbstractController
{
    public function __construct(
        private readonly InfrastructureServiceRepository $infrastructureServiceRepository,
    ) {
    }

    public function __invoke(
        #[MapEntity(mapping: [
            'id' => 'id',
        ])]
        InfrastructureService $infrastructureService,
        Request $request,
    ): Response {
        $form = $this->createForm(InfrastructureServiceForm::class, $infrastructureService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->infrastructureServiceRepository->save($form->getData());

            $this->addFlash(
                type: 'success',
                message: 'Service d\'infrastructure édité',
            );

            return $this->redirectToRoute(RouteCollection::LIST->prefixed());
        }

        return $this->render(
            view: 'panel/gestion/infrastructure-service/edit.html.twig',
            parameters: [
                'form' => $form->createView(),
                'entity' => $infrastructureService,
            ]
        );
    }
}
