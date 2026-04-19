<?php

namespace Panel\Infrastructure\Symfony\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Panel\Domain\Entity\DocTag;

/**
 * @extends AbstractEntityRepository<DocTag>
 */
class DocTagRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocTag::class);
    }

    public function save(DocTag $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
