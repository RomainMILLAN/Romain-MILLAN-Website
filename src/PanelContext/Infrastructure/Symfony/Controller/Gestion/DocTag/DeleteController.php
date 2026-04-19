<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\DocTag;

use Doctrine\ORM\EntityManagerInterface;
use Panel\Domain\Entity\DocTag;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/docs/tags/{id}/delete',
    name: RouteCollection::DELETE->value,
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
class DeleteController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(
        #[MapEntity(mapping: ['id' => 'id'])]
        DocTag $docTag,
    ): RedirectResponse {
        $this->entityManager->remove($docTag);
        $this->entityManager->flush();

        $this->addFlash(
            type: 'success',
            message: 'Le tag a bien été supprimé',
        );

        return $this->redirectToRoute(RouteCollection::LIST->prefixed());
    }
}
