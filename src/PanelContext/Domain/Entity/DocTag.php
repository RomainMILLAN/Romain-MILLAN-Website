<?php

namespace Panel\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Panel\Infrastructure\Symfony\Repository\DocTagRepository;

#[ORM\Entity(repositoryClass: DocTagRepository::class)]
class DocTag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    public ?string $name = null;

    #[ORM\Column(length: 7)]
    public ?string $color = '#6c757d';

    /**
     * @var Collection<int, DocPage>
     */
    #[ORM\ManyToMany(targetEntity: DocPage::class, mappedBy: 'tags')]
    private Collection $pages;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, DocPage>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
