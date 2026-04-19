<?php

namespace Panel\Infrastructure\Symfony\Controller\Gestion\DocPage;

use Doctrine\ORM\EntityManagerInterface;
use Panel\Domain\Entity\DocPage;
use Panel\Domain\Entity\DocTag;
use Panel\Infrastructure\Symfony\Repository\DocTagRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/docs/{id}/save',
    name: RouteCollection::SAVE->value,
    methods: [Request::METHOD_POST],
)]
class SaveController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DocTagRepository $docTagRepository,
    ) {
    }

    public function __invoke(
        #[MapEntity(mapping: ['id' => 'id'])]
        DocPage $docPage,
        Request $request,
    ): JsonResponse {
        $token = (string) $request->headers->get('X-CSRF-TOKEN', '');
        if (! $this->isCsrfTokenValid('docpage-save', $token)) {
            throw new BadRequestHttpException('Invalid CSRF token.');
        }

        $payload = json_decode($request->getContent(), true) ?? [];

        if (array_key_exists('title', $payload) && is_string($payload['title']) && trim($payload['title']) !== '') {
            $docPage->title = trim($payload['title']);
        }

        if (array_key_exists('content', $payload) && is_string($payload['content'])) {
            $docPage->content = $payload['content'];
        }

        if (array_key_exists('tagNames', $payload) && is_array($payload['tagNames'])) {
            $this->syncTags($docPage, $payload['tagNames']);
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'id' => $docPage->getId(),
            'title' => $docPage->title,
            'slug' => $docPage->slug,
            'updatedAt' => $docPage->updatedAt?->format(\DateTimeInterface::ATOM),
            'tags' => $docPage->getTags()->map(fn (DocTag $tag) => [
                'id' => $tag->getId(),
                'name' => $tag->name,
                'color' => $tag->color,
            ])->getValues(),
        ]);
    }

    /**
     * @param string[] $tagNames
     */
    private function syncTags(DocPage $docPage, array $tagNames): void
    {
        $names = array_values(array_unique(array_filter(array_map(
            fn ($name) => is_string($name) ? trim($name) : '',
            $tagNames,
        ))));

        $existing = $this->docTagRepository->createQueryBuilder('t')
            ->where('t.name IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->getResult();

        $byName = [];
        foreach ($existing as $tag) {
            $byName[$tag->name] = $tag;
        }

        $resolved = [];
        foreach ($names as $name) {
            if (isset($byName[$name])) {
                $resolved[] = $byName[$name];
                continue;
            }

            $tag = new DocTag();
            $tag->name = $name;
            $this->entityManager->persist($tag);
            $byName[$name] = $tag;
            $resolved[] = $tag;
        }

        foreach ($docPage->getTags()->toArray() as $current) {
            if (! in_array($current, $resolved, true)) {
                $docPage->removeTag($current);
            }
        }

        foreach ($resolved as $tag) {
            $docPage->addTag($tag);
        }
    }
}
