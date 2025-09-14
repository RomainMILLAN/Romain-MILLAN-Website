<?php

namespace Panel\Infrastructure\Symfony\Repository\Contracts;

use Doctrine\ORM\QueryBuilder;

interface EntityRepositoryInterface
{
    public function getListQueryBuilder(): QueryBuilder;
}
