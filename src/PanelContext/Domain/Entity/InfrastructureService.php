<?php

namespace Panel\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Panel\Infrastructure\Symfony\Repository\InfrastructureServiceRepository;

#[ORM\Entity(repositoryClass: InfrastructureServiceRepository::class)]
class InfrastructureService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column(length: 45)]
    public ?string $ipAddress = null;

    /**
     * @var Collection<int, Application>
     */
    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'infrastructureService')]
    private Collection $applications;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): static
    {
        if (! $this->applications->contains($application)) {
            $this->applications->add($application);
            $application->infrastructureService = $this;
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        if ($this->applications->removeElement($application)) {
            if ($application->infrastructureService === $this) {
                $application->infrastructureService = null;
            }
        }

        return $this;
    }
}
