<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'apu_equipment')]
#[ORM\HasLifecycleCallbacks]
class APUEquipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: APUItem::class, inversedBy: 'equipment')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?APUItem $apuItem = null;

    #[ORM\Column(type: 'string', length: 255, name: 'description')]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Tenant::class)]
    #[ORM\JoinColumn(name: 'tenant_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Tenant $tenant = null;

    #[ORM\ManyToOne(targetEntity: Projects::class)]
    #[ORM\JoinColumn(name: 'project_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Projects $project = null;

    #[ORM\ManyToOne(targetEntity: Template::class)]
    #[ORM\JoinColumn(name: 'template_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Template $template = null;

    #[ORM\ManyToOne(targetEntity: TemplateItem::class)]
    #[ORM\JoinColumn(name: 'template_item_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?TemplateItem $templateItem = null;

    #[ORM\ManyToOne(targetEntity: Equipment::class)]
    #[ORM\JoinColumn(name: 'equipment_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Equipment $equipment = null;

    #[ORM\Column(type: 'integer', name: 'number')]
    private int $number = 0;

    /** B — Tarifa (costo/hora del equipo) */
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, name: 'rate')]
    private string $rate = '0.00';

    /** C = A × B — Costo por hora */
    #[ORM\Column(type: 'decimal', precision: 14, scale: 4, name: 'cost_per_hour')]
    private string $costPerHour = '0.0000';

    /** R — Rendimiento u/h */
    #[ORM\Column(type: 'decimal', precision: 10, scale: 4, nullable: true, name: 'rendimiento_uh')]
    private ?string $rendimientoUh = null;

    /** D = C × R — Costo total */
    #[ORM\Column(type: 'decimal', precision: 14, scale: 4, nullable: true, name: 'cost_total')]
    private ?string $costTotal = null;

    #[ORM\Column(type: 'datetime', name: 'created_at')]
    private \DateTimeInterface $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApuItem(): ?APUItem
    {
        return $this->apuItem;
    }

    public function setApuItem(?APUItem $apuItem): self
    {
        $this->apuItem = $apuItem;
        if ($apuItem !== null && !$apuItem->getEquipment()->contains($this)) {
            $apuItem->addEquipment($this);
        }
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getRate(): string
    {
        return $this->rate;
    }

    /**
     * Accept numeric or string inputs and store as string (DB decimal)
     * @param float|int|string $rate
     */
    public function setRate(float|int|string $rate): self
    {
        $this->rate = (string) $rate;
        return $this;
    }

    public function getNumber(): int
    {
        return $this->number;
    }
    public function setNumber(int $n): self
    {
        $this->number = $n;
        return $this;
    }

    public function getRendimientoUh(): ?string
    {
        return $this->rendimientoUh;
    }
    public function setRendimientoUh(float|int|string|null $v): self
    {
        $this->rendimientoUh = $v === null ? null : (string)$v;
        return $this;
    }

    /** @deprecated use setRendimientoUh */
    public function setWorkHours(float|int|string|null $v): self
    {
        return $this->setRendimientoUh($v);
    }
    public function getWorkHours(): ?string
    {
        return $this->rendimientoUh;
    }

    public function getCostTotal(): ?string
    {
        return $this->costTotal;
    }
    public function setCostTotal(?string $v): self
    {
        $this->costTotal = $v;
        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function recalculate(): void
    {
        $a = (float)$this->number;
        $b = (float)$this->rate;
        $c = $a * $b;
        $this->costPerHour = number_format($c, 4, '.', '');
        if ($this->rendimientoUh !== null) {
            $this->costTotal = number_format($c * (float)$this->rendimientoUh, 4, '.', '');
        }
    }

    /**
     * @return string
     */
    public function getCostPerHour(): string
    {
        return $this->costPerHour;
    }

    /**
     * Accept numeric or string inputs and store as string (DB decimal)
     * @param float|int|string $costPerHour
     */
    public function setCostPerHour(float|int|string $costPerHour): self
    {
        $this->costPerHour = (string) $costPerHour;
        return $this;
    }

    // Backwards-compatible aliases (Spanish names)
    /** @param float|int|string $tarifa */
    public function setTarifa(float|int|string $tarifa): self
    {
        return $this->setRate($tarifa);
    }

    /** @param float|int|string $cHora */
    public function setCHora(float|int|string $cHora): self
    {
        return $this->setCostPerHour($cHora);
    }

    /** @return string */
    public function getTarifa(): string
    {
        return $this->getRate();
    }

    /** @return string */
    public function getCHora(): string
    {
        return $this->getCostPerHour();
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getTotalCost(): float
    {
        if ($this->costTotal !== null) return (float)$this->costTotal;
        return (float)$this->costPerHour * (float)($this->rendimientoUh ?? '1');
    }
}
