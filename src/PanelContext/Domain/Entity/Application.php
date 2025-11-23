<?php

namespace Panel\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
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

    /**
     * @var Collection<int, ApplicationType>
     */
    #[ORM\ManyToMany(targetEntity: ApplicationType::class, inversedBy: 'applications')]
    private Collection $type;

    /**
     * @var Collection<int, ApplicationCategory>
     */
    #[ORM\ManyToMany(targetEntity: ApplicationCategory::class, inversedBy: 'applications')]
    private Collection $categories;

    public function __construct()
    {
        $this->type = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, ApplicationCategory>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(ApplicationCategory $category): static
    {
        if (! $this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(ApplicationCategory $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getAvatarUrl(): string
    {
        return sprintf('https://cdn.jsdelivr.net/gh/homarr-labs/dashboard-icons/svg/%s.svg', $this->icon);
    }
}
