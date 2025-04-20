<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\ApplicationCategory;

use Doctrine\ORM\EntityManagerInterface;
use Panel\Domain\Entity\ApplicationCategory;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/applications/category/{id}/delete',
    name: RouteCollection::DELETE->value,
    methods: [Request::METHOD_POST],
)]
class DeleteController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(
        #[MapEntity(mapping: ['id' => 'id'])] ApplicationCategory $entity,
    ): Response {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        $this->addFlash(
            type: 'success',
            message: 'La catégorie à bien été supprimée'
        );

        return $this->redirectToRoute(RouteCollection::LIST->prefixed());
    }

}
