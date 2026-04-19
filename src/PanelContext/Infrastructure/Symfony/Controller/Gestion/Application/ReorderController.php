<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\Application;

use Doctrine\ORM\EntityManagerInterface;
use Panel\Infrastructure\Symfony\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/application/reorder',
    name: RouteCollection::REORDER->value,
    methods: [Request::METHOD_POST],
)]
class ReorderController extends AbstractController
{
    public function __construct(
        private readonly ApplicationRepository $applicationRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $token = (string) $request->headers->get('X-CSRF-TOKEN', '');
        if (! $this->isCsrfTokenValid('application-reorder', $token)) {
            throw new BadRequestHttpException('Invalid CSRF token.');
        }

        $payload = json_decode((string) $request->getContent(), true);
        $ids = $payload['ids'] ?? null;

        if (! is_array($ids) || $ids === []) {
            throw new BadRequestHttpException('Missing ids.');
        }

        $ids = array_values(array_map(static fn ($id): int => (int) $id, $ids));

        $applications = $this->applicationRepository->findBy(['id' => $ids]);
        $byId = [];
        foreach ($applications as $application) {
            $byId[$application->getId()] = $application;
        }

        if (count($byId) !== count($ids)) {
            throw new BadRequestHttpException('Unknown application id.');
        }

        $this->entityManager->wrapInTransaction(function () use ($ids, $byId): void {
            foreach ($ids as $position => $id) {
                $byId[$id]->orderNumber = $position;
            }
        });

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
