<?php

namespace Panel\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Panel\Infrastructure\Symfony\Repository\DocPageRepository;

#[ORM\Entity(repositoryClass: DocPageRepository::class)]
class DocPage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $title = null;

    #[Gedmo\Slug(fields: ['title'])]
    #[ORM\Column(length: 255, unique: true)]
    public ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, options: ['default' => ''])]
    public string $content = '';

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    public ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    public ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, DocTag>
     */
    #[ORM\ManyToMany(targetEntity: DocTag::class, inversedBy: 'pages', cascade: ['persist'])]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, DocTag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(DocTag $tag): static
    {
        if (! $this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(DocTag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
