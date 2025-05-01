<?php

namespace Panel\Infrastructure\Symfony\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Panel\Domain\Entity\ApplicationCategory;

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
}
