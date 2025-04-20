<?php

namespace Panel\Domain\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Panel\Domain\Entity\Entity\ApplicationType;
use Panel\Infrastructure\Symfony\Repository\ApplicationRepository;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    public ?string $url = null;

    #[ORM\Column(length: 255)]
    public ?string $icon = null;

    #[ORM\Column]
    public ?bool $hasInterface = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    public ?ApplicationCategory $category = null;

    /**
     * @var Collection<int, ApplicationType>
     */
    #[ORM\ManyToMany(targetEntity: ApplicationType::class, inversedBy: 'applications')]
    private Collection $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ApplicationType>
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(ApplicationType $type): static
    {
        if (! $this->type->contains($type)) {
            $this->type->add($type);
        }

        return $this;
    }

    public function removeType(ApplicationType $type): static
    {
        $this->type->removeElement($type);

        return $this;
    }
}
