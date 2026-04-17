<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'items')]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tenant::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Tenant $tenant;

    #[ORM\Column(name: 'code', type: 'string', length: 100)]
    private string $code;

    #[ORM\Column(name: 'nombre', type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'unit', type: 'string', length: 50)]
    private string $unit;

    /** type: general | personalizado */
    #[ORM\Column(name: 'tipo', type: 'string', length: 20)]
    private string $type = 'personalizado';

    #[ORM\Column(name: 'activo', type: 'boolean')]
    private bool $active = true;

    #[ORM\OneToMany(targetEntity: TemplateItem::class, mappedBy: 'item', cascade: ['remove'])]
    private Collection $templateItems;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->templateItems = new ArrayCollection();
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

    public function getCode(): string
    {
        return $this->code;
    }
    public function setCode(string $code): self
    {
        $this->code = $code;
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

    public function getUnit(): string
    {
        return $this->unit;
    }
    public function setUnit(string $unit): self
    {
        $this->unit = $unit;
        return $this;
    }

    // Backwards-compatible accessors (legacy template names)
    public function getCodigo(): string
    {
        return $this->code;
    }

    public function getNombre(): string
    {
        return $this->name;
    }

    public function getUnidad(): string
    {
        return $this->unit;
    }

    public function getType(): string
    {
        return $this->type;
    }
    public function setType(string $type): self
    {
        $this->type = $type;
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

    public function getTemplateItems(): Collection
    {
        return $this->templateItems;
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
