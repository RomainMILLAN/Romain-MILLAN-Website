<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\ApplicationType;

use Panel\Domain\Entity\ApplicationType;
use Panel\Infrastructure\Symfony\Form\ApplicationTypeForm;
use Panel\Infrastructure\Symfony\Repository\ApplicationTypeRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/application/type/{id}/edit',
    name: RouteCollection::EDIT->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class EditController extends AbstractController
{
    public function __construct(
        private readonly ApplicationTypeRepository $applicationTypeRepository,
    ) {
    }

    public function __invoke(
        Request $request,
        #[MapEntity(mapping: [
            'id' => 'id',
        ])]
        ApplicationType $entity,
    ): Response {
        $form = $this->createForm(ApplicationTypeForm::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applicationTypeRepository->save($entity);

            $this->addFlash(
                type: 'success',
                message: 'Type mis à jour',
            );

            return $this->redirectToRoute(RouteCollection::LIST->prefixed());
        }

        return $this->render(
            view: 'panel/gestion/applicationType/edit.html.twig',
            parameters: [
                'form' => $form->createView(),
                'entity' => $entity,
            ],
        );
    }
}
