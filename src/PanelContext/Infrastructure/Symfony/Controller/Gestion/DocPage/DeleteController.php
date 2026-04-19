<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\DocPage;

use Doctrine\ORM\EntityManagerInterface;
use Panel\Domain\Entity\DocPage;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/docs/{id}/delete',
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
        DocPage $docPage,
    ): RedirectResponse {
        $this->entityManager->remove($docPage);
        $this->entityManager->flush();

        $this->addFlash(
            type: 'success',
            message: 'La page de documentation a bien été supprimée',
        );

        return $this->redirectToRoute(RouteCollection::INDEX->prefixed());
    }
}
