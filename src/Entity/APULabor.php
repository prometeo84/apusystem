<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'apu_labor')]
#[ORM\HasLifecycleCallbacks]
class APULabor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: APUItem::class, inversedBy: 'labor')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?APUItem $apuItem = null;

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

    #[ORM\ManyToOne(targetEntity: APURubro::class, inversedBy: 'labor')]
    #[ORM\JoinColumn(name: 'apu_rubro_id', nullable: true, onDelete: 'CASCADE')]
    private ?APURubro $apuRubro = null;

    #[ORM\ManyToOne(targetEntity: Labor::class)]
    #[ORM\JoinColumn(name: 'labor_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Labor $labor = null;

    #[ORM\Column(type: 'integer', name: 'number')]
    private int $number = 0;

    /** B — JOR/HORA: tarifa base del trabajador ($/hora) */
    #[ORM\Column(type: 'decimal', precision: 14, scale: 4, name: 'jor_hour_b')]
    private string $jorHourB = '0.0000';

    /** C = A × B — Costo por hora = número × JOR/HORA */
    #[ORM\Column(type: 'decimal', precision: 14, scale: 4, name: 'cost_per_hour')]
    private string $costPerHour = '0.0000';

    /** R — Rendimiento u/h: unidades producidas por hora */
    #[ORM\Column(type: 'decimal', precision: 14, scale: 4, nullable: true, name: 'rendimiento_uh')]
    private ?string $rendimientoUh = null;

    /** D = C × R — Costo total de la fila */
    #[ORM\Column(type: 'decimal', precision: 14, scale: 4, nullable: true, name: 'cost_total')]
    private ?string $costTotal = null;

    #[ORM\Column(type: 'datetime')]
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
        if ($apuItem !== null && !$apuItem->getLabor()->contains($this)) {
            $apuItem->addLabor($this);
        }
        return $this;
    }

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }
    public function setTenant(?Tenant $t): self
    {
        $this->tenant = $t;
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

    public function getTemplate(): ?Template
    {
        return $this->template;
    }
    public function setTemplate(?Template $t): self
    {
        $this->template = $t;
        return $this;
    }

    public function getTemplateItem(): ?TemplateItem
    {
        return $this->templateItem;
    }
    public function setTemplateItem(?TemplateItem $ti): self
    {
        $this->templateItem = $ti;
        return $this;
    }

    public function getLabor(): ?Labor
    {
        return $this->labor;
    }
    public function setLabor(?Labor $l): self
    {
        $this->labor = $l;
        return $this;
    }

    public function getApuRubro(): ?APURubro
    {
        return $this->apuRubro;
    }
    public function setApuRubro(?APURubro $r): self
    {
        $this->apuRubro = $r;
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

    public function getJorHora(): string
    {
        return $this->jorHourB;
    }
    public function getJorHourB(): string
    {
        return $this->jorHourB;
    }
    public function setJorHora(float|int|string $v): self
    {
        $this->jorHourB = (string)$v;
        return $this;
    }
    public function setJorHourB(float|int|string $v): self
    {
        $this->jorHourB = (string)$v;
        return $this;
    }

    public function getCHora(): string
    {
        return $this->costPerHour;
    }
    public function getCostPerHour(): string
    {
        return $this->costPerHour;
    }
    public function setCHora(float|int|string $v): self
    {
        $this->costPerHour = (string)$v;
        return $this;
    }
    public function setCostPerHour(float|int|string $v): self
    {
        $this->costPerHour = (string)$v;
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
        $b = (float)$this->jorHourB;
        $c = $a * $b;
        $this->costPerHour = number_format($c, 4, '.', '');
        if ($this->rendimientoUh !== null) {
            $this->costTotal = number_format($c * (float)$this->rendimientoUh, 4, '.', '');
        }
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
