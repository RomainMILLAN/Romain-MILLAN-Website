<?php

namespace Panel\Infrastructure\Symfony\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Panel\Domain\Entity\InfrastructureService;

/**
 * @extends AbstractEntityRepository<InfrastructureService>
 */
class InfrastructureServiceRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfrastructureService::class);
    }

    public function save(InfrastructureService $entity): void
    {
        $this->getEntityManager()
            ->persist($entity);
        $this->getEntityManager()
            ->flush();
    }
}
