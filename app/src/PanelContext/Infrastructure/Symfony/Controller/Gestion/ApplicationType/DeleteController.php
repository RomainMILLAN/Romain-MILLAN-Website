<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\ApplicationType;

use Doctrine\ORM\EntityManagerInterface;
use Panel\Domain\Entity\ApplicationType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/application/type/{id}/delete',
    name: RouteCollection::DELETE->value,
    methods: [Request::METHOD_POST]
)]
class DeleteController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(
        #[MapEntity(mapping: [
            'id' => 'id',
        ])]
        ApplicationType $entity,
    ): Response {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        $this->addFlash(
            type: 'success',
            message: 'Type supprimé',
        );

        return $this->redirectToRoute(RouteCollection::LIST->prefixed());
    }
}
