<?php

namespace Panel\Infrastructure\Symfony\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Panel\Domain\Entity\Application;

/**
 * @extends ServiceEntityRepository<Application>
 */
class ApplicationRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    public function save(Application $entity): void
    {
        $this->getEntityManager()
            ->persist($entity);
        $this->getEntityManager()
            ->flush();
    }
}
