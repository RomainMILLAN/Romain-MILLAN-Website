<?php

namespace Panel\Infrastructure\Symfony\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Panel\Infrastructure\Symfony\Repository\Contracts\EntityRepositoryInterface;

abstract class AbstractEntityRepository extends ServiceEntityRepository implements EntityRepositoryInterface
{
    protected const ALIAS = 'o';

    public function getListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder(static::ALIAS);
    }
}
