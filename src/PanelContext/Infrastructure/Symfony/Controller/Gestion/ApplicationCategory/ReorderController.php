<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\ApplicationCategory;

use Panel\Domain\Exception\UnknownApplicationCategoryException;
use Panel\Infrastructure\Symfony\Repository\ApplicationCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/applications/category/reorder',
    name: RouteCollection::REORDER->value,
    methods: [Request::METHOD_POST],
)]
class ReorderController extends AbstractController
{
    public function __construct(
        private readonly ApplicationCategoryRepository $applicationCategoryRepository,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $token = (string) $request->headers->get('X-CSRF-TOKEN', '');
        if (! $this->isCsrfTokenValid('application-category-reorder', $token)) {
            throw new BadRequestHttpException('Invalid CSRF token.');
        }

        $payload = json_decode((string) $request->getContent(), true);
        $ids = $payload['ids'] ?? null;

        if (! is_array($ids) || $ids === []) {
            throw new BadRequestHttpException('Missing ids.');
        }

        $ids = array_values(array_map(static fn ($id): int => (int) $id, $ids));

        try {
            $this->applicationCategoryRepository->reorder($ids);
        } catch (UnknownApplicationCategoryException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
