<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;
use App\Entity\Projects;

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
    #[Assert\NotBlank(message: 'code.required')]
    #[Assert\Length(max: 100)]
    #[Assert\Regex(pattern: '/^[A-Za-z0-9\-\_\.]+$/', message: 'code.invalid')]
    private string $code;

    #[ORM\Column(name: 'name', type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'name.required')]
    #[Assert\Length(max: 255)]
    // Require at least one letter to avoid accepting numeric-only names
    #[Assert\Regex(pattern: '/^(?=.*\p{L})[\p{L}\d\s\-\._\(\),\/]+$/u', message: 'name.invalid')]
    private string $name;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'unit', type: 'string', length: 50)]
    #[Assert\NotBlank(message: 'unit.required')]
    private string $unit;

    /** type: general | personalizado */
    #[ORM\Column(name: 'type', type: 'string', length: 20)]
    private string $type = 'personalizado';

    #[ORM\Column(name: 'active', type: 'boolean')]
    private bool $active = true;

    #[ORM\OneToMany(targetEntity: TemplateItem::class, mappedBy: 'item', cascade: ['remove'])]
    private Collection $templateItems;

    #[ORM\ManyToOne(targetEntity: Projects::class)]
    #[ORM\JoinColumn(name: 'project_id', nullable: true, onDelete: 'CASCADE')]
    private ?Projects $project = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'created_by', nullable: true, onDelete: 'SET NULL')]
    private ?User $createdBy = null;

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

    public function getProject(): ?Projects
    {
        return $this->project;
    }

    public function setProject(?Projects $p): self
    {
        $this->project = $p;
        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $u): self
    {
        $this->createdBy = $u;
        return $this;
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
