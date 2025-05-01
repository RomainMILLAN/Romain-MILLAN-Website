<?php

namespace Panel\Infrastructure\Symfony\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Panel\Domain\Entity\ApplicationType;

/**
 * @extends ServiceEntityRepository<ApplicationType>
 */
class ApplicationTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplicationType::class);
    }

    public function save(ApplicationType $object): void
    {
        $this->getEntityManager()
            ->persist($object);
        $this->getEntityManager()
            ->flush();
    }
}
