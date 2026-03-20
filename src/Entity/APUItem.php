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
    private float $khu; // K(H/U) - Coeficiente hora/unidad

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private float $rendimientoUh; // Rend. u/h - Rendimiento unidad/hora

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?float $totalCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?float $equipmentCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?float $laborCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?float $materialCost = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?float $transportCost = null;

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

    public function getKhu(): float
    {
        return $this->khu;
    }

    public function setKhu(float $khu): self
    {
        $this->khu = $khu;
        $this->updatedAt = new \DateTime();
        return $this;
    }

    public function getRendimientoUh(): float
    {
        return $this->rendimientoUh;
    }

    public function setRendimientoUh(float $rendimientoUh): self
    {
        $this->rendimientoUh = $rendimientoUh;
        $this->updatedAt = new \DateTime();
        return $this;
    }

    public function getTotalCost(): ?float
    {
        return $this->totalCost;
    }

    public function setTotalCost(?float $totalCost): self
    {
        $this->totalCost = $totalCost;
        return $this;
    }

    public function getEquipmentCost(): ?float
    {
        return $this->equipmentCost;
    }

    public function setEquipmentCost(?float $equipmentCost): self
    {
        $this->equipmentCost = $equipmentCost;
        return $this;
    }

    public function getLaborCost(): ?float
    {
        return $this->laborCost;
    }

    public function setLaborCost(?float $laborCost): self
    {
        $this->laborCost = $laborCost;
        return $this;
    }

    public function getMaterialCost(): ?float
    {
        return $this->materialCost;
    }

    public function setMaterialCost(?float $materialCost): self
    {
        $this->materialCost = $materialCost;
        return $this;
    }

    public function getTransportCost(): ?float
    {
        return $this->transportCost;
    }

    public function setTransportCost(?float $transportCost): self
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
        $this->equipmentCost = 0;
        $this->laborCost = 0;
        $this->materialCost = 0;
        $this->transportCost = 0;

        foreach ($this->equipment as $equipment) {
            $this->equipmentCost += $equipment->getTarifa() * $equipment->getCHora();
        }

        foreach ($this->labor as $labor) {
            $this->laborCost += $labor->getJorHora() * $labor->getCHora();
        }

        foreach ($this->materials as $material) {
            $this->materialCost += $material->getCantidad() * $material->getPrecioUnitario();
        }

        foreach ($this->transport as $transport) {
            $this->transportCost += $transport->getCantidad() * $transport->getDmt() * $transport->getTarifaKm();
        }

        $this->totalCost = $this->equipmentCost + $this->laborCost +
            $this->materialCost + $this->transportCost;

        return $this;
    }
}
