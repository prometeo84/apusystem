<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'apu_equipment')]
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

    #[ORM\Column(type: 'integer', name: 'quantity')]
    private int $quantity;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, name: 'rate')]
    private string $rate; // formerly 'tarifa'

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4, name: 'cost_per_hour')]
    private string $costPerHour; // formerly 'c_hora'

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
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
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
        return (float) $this->rate * (float) $this->costPerHour;
    }
}
