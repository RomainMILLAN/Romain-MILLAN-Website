<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\InfrastructureService;

use Doctrine\ORM\EntityManagerInterface;
use Panel\Domain\Entity\InfrastructureService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/infrastructure-service/{id}/delete',
    name: RouteCollection::DELETE->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class DeleteController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(
        #[MapEntity(mapping: [
            'id' => 'id',
        ])]
        InfrastructureService $infrastructureService,
    ): RedirectResponse {
        $this->entityManager->remove($infrastructureService);
        $this->entityManager->flush();

        $this->addFlash(
            type: 'success',
            message: 'Le service d\'infrastructure à bien été supprimé',
        );

        return $this->redirectToRoute(RouteCollection::LIST->prefixed());
    }
}
