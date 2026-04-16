<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'apu_items')]
class APUItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tenant::class)]
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

    #[ORM\Column(name: 'rendimiento_uh', type: 'decimal', precision: 10, scale: 4)]
    private string $productivityUh; // Rend. u/h - Productivity units/hour

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $totalCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $equipmentCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $laborCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $materialCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $transportCost = null;

    /** Profit percentage applied to the calculation price */
    #[ORM\Column(name: 'utilidad_pct', type: 'decimal', precision: 5, scale: 2, nullable: true)]
    private ?string $profitPct = null;

    /** Final offered price (USD) defined manually or equal to the calculation price */
    #[ORM\Column(name: 'precio_ofertado', type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $offeredPrice = null;

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
        $this->equipment = new ArrayCollection();
        $this->labor = new ArrayCollection();
        $this->materials = new ArrayCollection();
        $this->transport = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

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

    public function setKhu(string $khu): self
    {
        $this->khu = $khu;
        $this->updatedAt = new \DateTime();
        return $this;
    }

    public function getProductivityUh(): string
    {
        return $this->productivityUh;
    }

    public function setProductivityUh(string $productivityUh): self
    {
        $this->productivityUh = $productivityUh;
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

    /**
     * Calcular costos totales automáticamente
     */
    public function calculateCosts(): self
    {
        $this->equipmentCost = null;
        $this->laborCost = null;
        $this->materialCost = null;
        $this->transportCost = null;

        $equipmentSum = 0.0;
        foreach ($this->equipment as $equipment) {
            $equipmentSum += (float) $equipment->getTarifa() * (float) $equipment->getCHora();
        }

        $laborSum = 0.0;
        foreach ($this->labor as $labor) {
            $laborSum += (float) $labor->getJorHora() * (float) $labor->getCHora();
        }

        $materialSum = 0.0;
        foreach ($this->materials as $material) {
            $materialSum += (float) $material->getQuantity() * (float) $material->getUnitPrice();
        }

        $transportSum = 0.0;
        foreach ($this->transport as $transport) {
            $transportSum += (float) $transport->getQuantity() * (float) $transport->getDmt() * (float) $transport->getTarifaKm();
        }

        $this->equipmentCost = (string) $equipmentSum;
        $this->laborCost = (string) $laborSum;
        $this->materialCost = (string) $materialSum;
        $this->transportCost = (string) $transportSum;

        $this->totalCost = (string) ($equipmentSum + $laborSum + $materialSum + $transportSum);

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

    public function getOfferedPrice(): ?string
    {
        return $this->offeredPrice;
    }
    public function setOfferedPrice(?string $v): self
    {
        $this->offeredPrice = $v;
        return $this;
    }

    /** Calculation price = totalCost * (1 + profitPct/100) */
    public function getCalculationPrice(): float
    {
        $base = (float) ($this->totalCost ?? 0);
        $pct  = (float) ($this->profitPct ?? 0);
        return $base * (1 + $pct / 100);
    }
}
