<?php

namespace Panel\Infrastructure\Symfony\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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

    public function searchByName(string $query): QueryBuilder
    {
        $qb = $this->createQueryBuilder('a');

        $value = \sprintf('%%%s%%', $query);
        $expr = $qb->expr();

        $qb->andWhere(
            $qb->expr()
                ->orX(
                    $qb->expr()
                        ->like('a.name', $qb->expr()->literal($value)),
                    $qb->expr()
                        ->like('a.description', $qb->expr()->literal($value)),
                )
        );

        return $qb;
    }
}
