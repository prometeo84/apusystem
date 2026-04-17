<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'apu_labor')]
class APULabor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: APUItem::class, inversedBy: 'labor')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?APUItem $apuItem = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $description;

    #[ORM\Column(type: 'integer')]
    private int $quantity;


    #[ORM\Column(type: 'decimal', precision: 10, scale: 4, name: 'work_hours')]
    private string $workHours; // formerly 'jor_hora'

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, name: 'cost_per_hour')]
    private string $costPerHour; // formerly 'c_hora' (Costo por hora)

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

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getJorHora(): string
    {
        return $this->workHours;
    }

    public function setJorHora(string $jorHora): self
    {
        $this->workHours = $jorHora;
        return $this;
    }

    public function getCHora(): string
    {
        return $this->costPerHour;
    }

    public function setCHora(string $cHora): self
    {
        $this->costPerHour = $cHora;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getTotalCost(): float
    {
        return (float) $this->workHours * (float) $this->costPerHour;
    }
}
