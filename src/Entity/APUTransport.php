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

    #[ORM\Column(type: 'string', length: 255)]
    private string $description;

    #[ORM\Column(type: 'string', length: 50)]
    private string $unit;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 4)]
    private string $quantity; // QUANTITY

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, name: 'avg_distance')]
    private string $avgDistance; // formerly 'dmt' (Distancia media de transporte)

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, name: 'rate_per_km')]
    private string $ratePerKm; // formerly 'tarifa_km'

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
    public function getAvgDistance(): string
    {
        return $this->avgDistance;
    }

    public function setAvgDistance(string $avgDistance): self
    {
        $this->avgDistance = $avgDistance;
        return $this;
    }

    public function getRatePerKm(): string
    {
        return $this->ratePerKm;
    }

    public function setRatePerKm(string $ratePerKm): self
    {
        $this->ratePerKm = $ratePerKm;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getTotalCost(): float
    {
        return (float) $this->quantity * (float) $this->avgDistance * (float) $this->ratePerKm;
    }
}
