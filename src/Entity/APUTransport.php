<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'apu_transport')]
class APUTransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: APUItem::class, inversedBy: 'transport')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?APUItem $apuItem = null;

    #[ORM\Column(name: 'descripcion', type: 'string', length: 255)]
    private string $description;

    #[ORM\Column(name: 'unidad', type: 'string', length: 50)]
    private string $unit;

    #[ORM\Column(name: 'cantidad', type: 'decimal', precision: 15, scale: 4)]
    private string $quantity; // QUANTITY

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $dmt; // DMT (km) - Distancia Media de Transporte

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $tarifaKm; // Tarifa por kilómetro

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

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;
        return $this;
    }

    public function getQuantity(): string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getDmt(): string
    {
        return $this->dmt;
    }

    public function setDmt(string $dmt): self
    {
        $this->dmt = $dmt;
        return $this;
    }

    public function getTarifaKm(): string
    {
        return $this->tarifaKm;
    }

    public function setTarifaKm(string $tarifaKm): self
    {
        $this->tarifaKm = $tarifaKm;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getTotalCost(): float
    {
        return (float) $this->quantity * (float) $this->dmt * (float) $this->tarifaKm;
    }
}
