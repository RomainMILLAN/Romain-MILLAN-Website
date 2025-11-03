<?php

namespace App\Domain\Entity;

use App\Infrastructure\Symfony\Repository\PushNotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PushNotificationRepository::class)]
#[ORM\UniqueConstraint(
    name: 'unique_push_notification',
    columns: ['endpoint', 'p256dh', 'auth']
)]
class PushNotification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $endpoint = null;

    #[ORM\Column(length: 255)]
    public ?string $p256dh = null;

    #[ORM\Column(length: 255)]
    public ?string $auth = null;

    public function __construct(?string $endpoint, ?string $p256dh, ?string $auth)
    {
        $this->endpoint = $endpoint;
        $this->p256dh = $p256dh;
        $this->auth = $auth;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
