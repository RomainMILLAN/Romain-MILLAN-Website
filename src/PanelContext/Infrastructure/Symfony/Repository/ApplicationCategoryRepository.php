<?php

namespace Panel\Infrastructure\Symfony\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Panel\Domain\Entity\ApplicationCategory;
use Panel\Domain\Exception\UnknownApplicationCategoryException;

/**
 * @extends ServiceEntityRepository<ApplicationCategory>
 */
class ApplicationCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplicationCategory::class);
    }

    public function save(ApplicationCategory $object): void
    {
        $this->getEntityManager()
            ->persist($object);
        $this->getEntityManager()
            ->flush();
    }

    /**
     * @param int[] $ids Position implicite = index dans le tableau
     *
     * @throws UnknownApplicationCategoryException
     */
    public function reorder(array $ids): void
    {
        if (count($ids) !== count(array_unique($ids))) {
            throw new UnknownApplicationCategoryException('Duplicate application category id.');
        }

        $entities = $this->findBy(['id' => $ids]);

        if (count($entities) !== count($ids)) {
            throw new UnknownApplicationCategoryException('Unknown application category id.');
        }

        $byId = [];
        foreach ($entities as $entity) {
            $byId[$entity->getId()] = $entity;
        }

        $em = $this->getEntityManager();
        $em->wrapInTransaction(function () use ($ids, $byId): void {
            foreach ($ids as $position => $id) {
                $byId[$id]->moveTo($position);
            }
        });
    }
}
