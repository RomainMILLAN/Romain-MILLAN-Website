<?php

namespace Panel\Infrastructure\Symfony\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Panel\Domain\Entity\DocPage;

/**
 * @extends AbstractEntityRepository<DocPage>
 */
class DocPageRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocPage::class);
    }

    public function save(DocPage $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @return DocPage[]
     */
    public function findAllOrderedByTitle(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function searchByTitleOrContent(string $query): QueryBuilder
    {
        $qb = $this->createQueryBuilder('p');

        $value = '%' . addcslashes($query, '%_\\') . '%';

        return $qb->andWhere(
            $qb->expr()->orX(
                $qb->expr()->like('p.title', ':value'),
                $qb->expr()->like('p.content', ':value'),
            )
        )
            ->setParameter('value', $value)
            ->orderBy('p.title', 'ASC');
    }
}
