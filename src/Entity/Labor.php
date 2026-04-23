<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Projects;

#[ORM\Entity]
#[ORM\Table(name: 'labors')]
#[ORM\HasLifecycleCallbacks]
class Labor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tenant::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Tenant $tenant;

    #[ORM\Column(type: 'string', length: 100)]
    private string $code;

    #[ORM\Column(type: 'string', length: 255, name: 'description')]
    private string $description;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $unit = null;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 4, nullable: true)]
    private ?string $numberA = null;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 4, nullable: true)]
    private ?string $jorHourB = null;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 4, nullable: true)]
    private ?string $rendR = null;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 4, nullable: true)]
    private ?string $costHourC = null;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 4, nullable: true)]
    private ?string $costTotalD = null;

    #[ORM\Column(type: 'boolean')]
    private bool $active = true;

    #[ORM\ManyToOne(targetEntity: Projects::class)]
    #[ORM\JoinColumn(name: 'project_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Projects $project = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
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
    public function setTenant(Tenant $t): self
    {
        $this->tenant = $t;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }
    public function setCode(string $c): self
    {
        $this->code = $c;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $d): self
    {
        $this->description = $d;
        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }
    public function setUnit(?string $u): self
    {
        $this->unit = $u;
        return $this;
    }

    public function getNumberA(): ?string
    {
        return $this->numberA;
    }
    public function setNumberA(?string $v): self
    {
        $this->numberA = $v;
        return $this;
    }

    public function getJorHourB(): ?string
    {
        return $this->jorHourB;
    }
    public function setJorHourB(?string $v): self
    {
        $this->jorHourB = $v;
        return $this;
    }

    public function getRendR(): ?string
    {
        return $this->rendR;
    }
    public function setRendR(?string $v): self
    {
        $this->rendR = $v;
        return $this;
    }

    public function getCostHourC(): ?string
    {
        return $this->costHourC;
    }
    public function setCostHourC(?string $v): self
    {
        $this->costHourC = $v;
        return $this;
    }

    public function getCostTotalD(): ?string
    {
        return $this->costTotalD;
    }
    public function setCostTotalD(?string $v): self
    {
        $this->costTotalD = $v;
        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function calculateCosts(): void
    {
        $a = $this->numberA !== null ? (float) $this->numberA : null;
        $b = $this->jorHourB !== null ? (float) $this->jorHourB : null;
        $r = $this->rendR !== null ? (float) $this->rendR : null;
        $c = null;
        $d = null;
        if ($a !== null && $b !== null) {
            $c = $a * $b;
        }
        if ($c !== null && $r !== null) {
            $d = $c * $r;
        }
        $this->costHourC = $c !== null ? number_format($c, 4, '.', '') : null;
        $this->costTotalD = $d !== null ? number_format($d, 4, '.', '') : null;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
    public function setActive(bool $a): self
    {
        $this->active = $a;
        return $this;
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
