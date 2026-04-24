<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\User;

#[ORM\Entity]
#[ORM\Table(name: 'apu_items')]
class APUItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tenant::class, inversedBy: 'apuItems')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Tenant $tenant;

    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $uuid;

    #[ORM\Column(type: 'string', length: 255)]
    private string $description;

    #[ORM\Column(type: 'string', length: 50)]
    private string $unit;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private string $khu; // K(H/U) - Coeficiente hora/unidad

    #[ORM\Column(name: 'productivity_uh', type: 'decimal', precision: 10, scale: 4)]
    private string $productivityUh; // Rend. u/h - Productivity units/hour

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $totalCost = null;

    /** Precio de cálculo = total_cost × (1 + profit_pct/100) — persisted to avoid recalculation in reports */
    #[ORM\Column(name: 'calculation_price', type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $calculationPriceStored = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $equipmentCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $laborCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $materialCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $transportCost = null;

    /** Profit percentage applied to the calculation price */
    #[ORM\Column(name: 'profit_pct', type: 'decimal', precision: 5, scale: 2, nullable: true)]
    private ?string $profitPct = null;

    /** Indirect costs percentage (gastos generales, imprevistos, etc.) */
    #[ORM\Column(name: 'indirect_cost_pct', type: 'decimal', precision: 5, scale: 2, nullable: true)]
    private ?string $indirectCostPct = null;

    /** Final offered price (USD) defined manually or equal to the calculation price */
    #[ORM\Column(name: 'offered_price', type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $offeredPrice = null;

    #[ORM\OneToMany(targetEntity: APURubro::class, mappedBy: 'apuItem', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC', 'id' => 'ASC'])]
    private Collection $rubros;

    #[ORM\OneToMany(targetEntity: APUEquipment::class, mappedBy: 'apuItem', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $equipment;

    #[ORM\OneToMany(targetEntity: APULabor::class, mappedBy: 'apuItem', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $labor;

    #[ORM\OneToMany(targetEntity: APUMaterial::class, mappedBy: 'apuItem', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $materials;

    #[ORM\OneToMany(targetEntity: APUTransport::class, mappedBy: 'apuItem', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $transport;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->uuid = $this->generateUuid();
        $this->rubros = new ArrayCollection();
        $this->equipment = new ArrayCollection();
        $this->labor = new ArrayCollection();
        $this->materials = new ArrayCollection();
        $this->transport = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'created_by', nullable: true, onDelete: 'SET NULL')]
    private ?User $createdBy = null;

    private function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            \mt_rand(0, 0xffff),
            \mt_rand(0, 0xffff),
            \mt_rand(0, 0xffff),
            \mt_rand(0, 0x0fff) | 0x4000,
            \mt_rand(0, 0x3fff) | 0x8000,
            \mt_rand(0, 0xffff),
            \mt_rand(0, 0xffff),
            \mt_rand(0, 0xffff)
        );
    }

    // Getters and Setters

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
        if ($tenant !== null && method_exists($tenant, 'getApuItems') && !$tenant->getApuItems()->contains($this)) {
            $tenant->getApuItems()->add($this);
        }
        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        $this->updatedAt = new \DateTime();
        return $this;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;
        $this->updatedAt = new \DateTime();
        return $this;
    }

    public function getKhu(): string
    {
        return $this->khu;
    }

    /**
     * @param float|int|string $khu
     */
    public function setKhu(float|int|string $khu): self
    {
        $this->khu = (string) $khu;
        $this->updatedAt = new \DateTime();
        return $this;
    }

    public function getProductivityUh(): string
    {
        return $this->productivityUh;
    }

    /**
     * Alias en español para compatibilidad con plantillas antiguas.
     * @return string
     */
    public function getRendimientoUh(): string
    {
        return $this->productivityUh;
    }

    /**
     * @param float|int|string $productivityUh
     */
    public function setProductivityUh(float|int|string $productivityUh): self
    {
        $this->productivityUh = (string) $productivityUh;
        $this->updatedAt = new \DateTime();
        return $this;
    }

    public function getTotalCost(): ?string
    {
        return $this->totalCost;
    }

    public function setTotalCost(?string $totalCost): self
    {
        $this->totalCost = $totalCost;
        return $this;
    }

    public function getEquipmentCost(): ?string
    {
        return $this->equipmentCost;
    }

    public function setEquipmentCost(?string $equipmentCost): self
    {
        $this->equipmentCost = $equipmentCost;
        return $this;
    }

    public function getLaborCost(): ?string
    {
        return $this->laborCost;
    }

    public function setLaborCost(?string $laborCost): self
    {
        $this->laborCost = $laborCost;
        return $this;
    }

    public function getMaterialCost(): ?string
    {
        return $this->materialCost;
    }

    public function setMaterialCost(?string $materialCost): self
    {
        $this->materialCost = $materialCost;
        return $this;
    }

    public function getTransportCost(): ?string
    {
        return $this->transportCost;
    }

    public function setTransportCost(?string $transportCost): self
    {
        $this->transportCost = $transportCost;
        return $this;
    }

    public function getIndirectCostPct(): ?string
    {
        return $this->indirectCostPct;
    }
    public function setIndirectCostPct(?string $v): self
    {
        $this->indirectCostPct = $v;
        return $this;
    }

    public function getRubros(): Collection
    {
        return $this->rubros;
    }
    public function addRubro(APURubro $rubro): self
    {
        if (!$this->rubros->contains($rubro)) {
            $this->rubros->add($rubro);
            $rubro->setApuItem($this);
        }
        return $this;
    }
    public function removeRubro(APURubro $rubro): self
    {
        $this->rubros->removeElement($rubro);
        return $this;
    }

    public function getEquipment(): Collection
    {
        return $this->equipment;
    }

    public function addEquipment(APUEquipment $equipment): self
    {
        if (!$this->equipment->contains($equipment)) {
            $this->equipment[] = $equipment;
            $equipment->setApuItem($this);
        }
        return $this;
    }

    public function removeEquipment(APUEquipment $equipment): self
    {
        if ($this->equipment->removeElement($equipment)) {
            if ($equipment->getApuItem() === $this) {
                $equipment->setApuItem(null);
            }
        }
        return $this;
    }

    public function getLabor(): Collection
    {
        return $this->labor;
    }

    public function addLabor(APULabor $labor): self
    {
        if (!$this->labor->contains($labor)) {
            $this->labor[] = $labor;
            $labor->setApuItem($this);
        }
        return $this;
    }

    public function removeLabor(APULabor $labor): self
    {
        if ($this->labor->removeElement($labor)) {
            if ($labor->getApuItem() === $this) {
                $labor->setApuItem(null);
            }
        }
        return $this;
    }

    public function getMaterials(): Collection
    {
        return $this->materials;
    }

    public function addMaterial(APUMaterial $material): self
    {
        if (!$this->materials->contains($material)) {
            $this->materials[] = $material;
            $material->setApuItem($this);
        }
        return $this;
    }

    public function removeMaterial(APUMaterial $material): self
    {
        if ($this->materials->removeElement($material)) {
            if ($material->getApuItem() === $this) {
                $material->setApuItem(null);
            }
        }
        return $this;
    }

    public function getTransport(): Collection
    {
        return $this->transport;
    }

    public function addTransport(APUTransport $transport): self
    {
        if (!$this->transport->contains($transport)) {
            $this->transport[] = $transport;
            $transport->setApuItem($this);
        }
        return $this;
    }

    public function removeTransport(APUTransport $transport): self
    {
        if ($this->transport->removeElement($transport)) {
            if ($transport->getApuItem() === $this) {
                $transport->setApuItem(null);
            }
        }
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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $user): self
    {
        $this->createdBy = $user;
        return $this;
    }

    /**
     * Calcular costos totales automáticamente.
     * Formulas:
     *   Equipment: C = A×B (number × rate); D = C×R (costPerHour × rendimientoUh)
     *   Labor:     C = A×B (number × jorHourB); D = C×R (costPerHour × rendimientoUh)
     *   Material:  D = Cantidad × PrecioUnitario
     *   Transport: D = Cantidad × DMT × TarifaKm
     */
    public function calculateCosts(): self
    {
        $equipmentSum = 0.0;
        $laborSum     = 0.0;
        $materialSum  = 0.0;
        $transportSum = 0.0;

        // Calcular desde los rubros (nueva estructura)
        foreach ($this->rubros as $rubro) {
            $rubro->calculateCosts();
            $equipmentSum += (float)$rubro->getEquipmentCost();
            $laborSum     += (float)$rubro->getLaborCost();
            $materialSum  += (float)$rubro->getMaterialCost();
            $transportSum += (float)$rubro->getTransportCost();
        }

        // Calcular componentes directos (estructura legada — sin rubro asignado)
        foreach ($this->equipment as $equip) {
            if ($equip->getApuRubro() === null) {
                $equip->recalculate();
                $equipmentSum += $equip->getTotalCost();
            }
        }
        foreach ($this->labor as $labor) {
            if ($labor->getApuRubro() === null) {
                $labor->recalculate();
                $laborSum += $labor->getTotalCost();
            }
        }
        foreach ($this->materials as $material) {
            if ($material->getApuRubro() === null) {
                $materialSum += (float)$material->getQuantity() * (float)$material->getUnitPrice();
            }
        }
        foreach ($this->transport as $transport) {
            if ($transport->getApuRubro() === null) {
                $transport->recalculate();
                $transportSum += $transport->getTotalCost();
            }
        }

        $this->equipmentCost  = number_format($equipmentSum,  2, '.', '');
        $this->laborCost      = number_format($laborSum,      2, '.', '');
        $this->materialCost   = number_format($materialSum,   2, '.', '');
        $this->transportCost  = number_format($transportSum,  2, '.', '');

        $directCosts = $equipmentSum + $laborSum + $materialSum + $transportSum;
        $this->totalCost = number_format($directCosts, 2, '.', '');

        $indirectPct = (float)($this->indirectCostPct ?? '0');
        $profitPct   = (float)($this->profitPct ?? '0');
        $this->calculationPriceStored = number_format(
            $directCosts * (1 + $indirectPct / 100) * (1 + $profitPct / 100),
            2,
            '.',
            ''
        );

        return $this;
    }

    public function getProfitPct(): ?string
    {
        return $this->profitPct;
    }
    public function setProfitPct(?string $v): self
    {
        $this->profitPct = $v;
        return $this;
    }

    /**
     * Alias en español para compatibilidad con plantillas antiguas.
     * @return ?string
     */
    public function getUtilidadPct(): ?string
    {
        return $this->profitPct;
    }

    public function getOfferedPrice(): ?string
    {
        return $this->offeredPrice;
    }
    public function setOfferedPrice(?string $v): self
    {
        $this->offeredPrice = $v;
        return $this;
    }

    /**
     * Alias en español para compatibilidad con plantillas antiguas.
     * @return ?string
     */
    public function getPrecioOfertado(): ?string
    {
        return $this->offeredPrice;
    }

    /** Calculation price = totalCost * (1 + profitPct/100) */
    public function getCalculationPrice(): float
    {
        if ($this->calculationPriceStored !== null) {
            return (float) $this->calculationPriceStored;
        }
        $base = (float) ($this->totalCost ?? 0);
        $pct  = (float) ($this->profitPct ?? 0);
        return $base * (1 + $pct / 100);
    }

    public function getCalculationPriceStored(): ?string
    {
        return $this->calculationPriceStored;
    }
    public function setCalculationPriceStored(?string $v): self
    {
        $this->calculationPriceStored = $v;
        return $this;
    }

    /**
     * Alias en español para compatibilidad con plantillas antiguas.
     * @return float
     */
    public function getPrecioCalculo(): float
    {
        return $this->getCalculationPrice();
    }
}
