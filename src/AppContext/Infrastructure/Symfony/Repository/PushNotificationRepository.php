<?php

namespace App\Infrastructure\Symfony\Repository;

use App\Domain\Entity\PushNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PushNotification>
 */
class PushNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PushNotification::class);
    }
}
