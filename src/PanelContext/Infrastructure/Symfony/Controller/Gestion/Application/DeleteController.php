<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\Application;

use Doctrine\ORM\EntityManagerInterface;
use Panel\Domain\Entity\Application;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/application/{id}/delete',
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
        Application $application,
    ): RedirectResponse {
        $this->entityManager->remove($application);
        $this->entityManager->flush();

        $this->addFlash(
            type: 'success',
            message: 'L\'application à bien été supprimée',
        );

        return $this->redirectToRoute(RouteCollection::LIST->prefixed());
    }
}
