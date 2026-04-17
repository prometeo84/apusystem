<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'templates')]
class Template
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tenant::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Tenant $tenant;

    #[ORM\ManyToOne(targetEntity: Projects::class, inversedBy: 'templates')]
    #[ORM\JoinColumn(name: 'project_id', nullable: false, onDelete: 'CASCADE')]
    private Projects $project;

    #[ORM\Column(name: 'name', type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'active', type: 'boolean')]
    private bool $active = true;

    #[ORM\OneToMany(targetEntity: TemplateItem::class, mappedBy: 'template', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['order' => 'ASC'])]
    private Collection $items;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTenant(): Tenant
    {
        return $this->tenant;
    }
    public function setTenant(Tenant $tenant): self
    {
        $this->tenant = $tenant;
        return $this;
    }

    public function getProject(): Projects
    {
        return $this->project;
    }
    public function setProject(Projects $project): self
    {
        $this->project = $project;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $d): self
    {
        $this->description = $d;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(TemplateItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setTemplate($this);
        }
        return $this;
    }

    public function removeItem(TemplateItem $item): self
    {
        $this->items->removeElement($item);
        return $this;
    }

    /** Total budget = sum of all item costs */
    public function getTotalBudget(): float
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            $total += $item->getTotalCost();
        }
        return $total;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(\DateTimeInterface $d): self
    {
        $this->updatedAt = $d;
        return $this;
    }
}
