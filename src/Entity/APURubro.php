<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'apu_rubros')]
#[ORM\HasLifecycleCallbacks]
class APURubro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: APUItem::class, inversedBy: 'rubros')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?APUItem $apuItem = null;

    /** Rubro del catálogo (opcional — si null, el nombre se introduce libremente) */
    #[ORM\ManyToOne(targetEntity: Item::class)]
    #[ORM\JoinColumn(name: 'item_id', nullable: true, onDelete: 'SET NULL')]
    private ?Item $item = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name = '';

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $unit = null;

    #[ORM\Column(name: 'khu', type: 'decimal', precision: 10, scale: 4, nullable: true)]
    private ?string $khu = null;

    #[ORM\Column(name: 'rendimiento_uh', type: 'decimal', precision: 10, scale: 4, nullable: true)]
    private ?string $productivityUh = null;

    #[ORM\Column(type: 'integer')]
    private int $position = 0;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $equipmentCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $laborCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $materialCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $transportCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $totalCost = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\OneToMany(targetEntity: APUEquipment::class, mappedBy: 'apuRubro', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['id' => 'ASC'])]
    private Collection $equipment;

    #[ORM\OneToMany(targetEntity: APULabor::class, mappedBy: 'apuRubro', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['id' => 'ASC'])]
    private Collection $labor;

    #[ORM\OneToMany(targetEntity: APUMaterial::class, mappedBy: 'apuRubro', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['id' => 'ASC'])]
    private Collection $materials;

    #[ORM\OneToMany(targetEntity: APUTransport::class, mappedBy: 'apuRubro', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['id' => 'ASC'])]
    private Collection $transport;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->equipment = new ArrayCollection();
        $this->labor     = new ArrayCollection();
        $this->materials = new ArrayCollection();
        $this->transport = new ArrayCollection();
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
        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }
    public function setItem(?Item $item): self
    {
        $this->item = $item;
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

    public function getUnit(): ?string
    {
        return $this->unit;
    }
    public function setUnit(?string $v): self
    {
        $this->unit = $v;
        return $this;
    }

    public function getKhu(): ?string
    {
        return $this->khu;
    }
    public function setKhu(float|string|null $v): self
    {
        $this->khu = $v !== null ? (string)$v : null;
        return $this;
    }

    public function getProductivityUh(): ?string
    {
        return $this->productivityUh;
    }
    public function setProductivityUh(float|string|null $v): self
    {
        $this->productivityUh = $v !== null ? (string)$v : null;
        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getEquipmentCost(): ?string
    {
        return $this->equipmentCost;
    }
    public function getLaborCost(): ?string
    {
        return $this->laborCost;
    }
    public function getMaterialCost(): ?string
    {
        return $this->materialCost;
    }
    public function getTransportCost(): ?string
    {
        return $this->transportCost;
    }
    public function getTotalCost(): ?string
    {
        return $this->totalCost;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /* ── Equipment ─────────────────────────────────────────────────────── */
    public function getEquipment(): Collection
    {
        return $this->equipment;
    }
    public function addEquipment(APUEquipment $e): self
    {
        if (!$this->equipment->contains($e)) {
            $this->equipment->add($e);
            $e->setApuRubro($this);
        }
        return $this;
    }
    public function removeEquipment(APUEquipment $e): self
    {
        $this->equipment->removeElement($e);
        return $this;
    }

    /* ── Labor ─────────────────────────────────────────────────────────── */
    public function getLabor(): Collection
    {
        return $this->labor;
    }
    public function addLabor(APULabor $l): self
    {
        if (!$this->labor->contains($l)) {
            $this->labor->add($l);
            $l->setApuRubro($this);
        }
        return $this;
    }
    public function removeLabor(APULabor $l): self
    {
        $this->labor->removeElement($l);
        return $this;
    }

    /* ── Materials ─────────────────────────────────────────────────────── */
    public function getMaterials(): Collection
    {
        return $this->materials;
    }
    public function addMaterial(APUMaterial $m): self
    {
        if (!$this->materials->contains($m)) {
            $this->materials->add($m);
            $m->setApuRubro($this);
        }
        return $this;
    }
    public function removeMaterial(APUMaterial $m): self
    {
        $this->materials->removeElement($m);
        return $this;
    }

    /* ── Transport ─────────────────────────────────────────────────────── */
    public function getTransport(): Collection
    {
        return $this->transport;
    }
    public function addTransport(APUTransport $t): self
    {
        if (!$this->transport->contains($t)) {
            $this->transport->add($t);
            $t->setApuRubro($this);
        }
        return $this;
    }
    public function removeTransport(APUTransport $t): self
    {
        $this->transport->removeElement($t);
        return $this;
    }

    /** Recalcular costos totales del rubro */
    public function calculateCosts(): self
    {
        $eq = 0.0;
        foreach ($this->equipment as $e) {
            $e->recalculate();
            $eq += $e->getTotalCost();
        }

        $lb = 0.0;
        foreach ($this->labor as $l) {
            $l->recalculate();
            $lb += $l->getTotalCost();
        }

        $mt = 0.0;
        foreach ($this->materials as $m) {
            $mt += (float)$m->getQuantity() * (float)$m->getUnitPrice();
        }

        $tr = 0.0;
        foreach ($this->transport as $t) {
            $t->recalculate();
            $tr += $t->getTotalCost();
        }

        $this->equipmentCost  = number_format($eq, 2, '.', '');
        $this->laborCost      = number_format($lb, 2, '.', '');
        $this->materialCost   = number_format($mt, 2, '.', '');
        $this->transportCost  = number_format($tr, 2, '.', '');
        $this->totalCost      = number_format($eq + $lb + $mt + $tr, 2, '.', '');

        return $this;
    }

    public function getTotalCostFloat(): float
    {
        return (float)($this->totalCost ?? '0');
    }
}
