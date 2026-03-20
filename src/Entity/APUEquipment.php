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

    #[ORM\Column(type: 'string', length: 255)]
    private string $descripcion;

    #[ORM\Column(type: 'integer')]
    private int $numero;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $tarifa; // Tarifa

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private float $cHora; // C/HORA (Costo por hora)

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

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;
        return $this;
    }

    public function getTarifa(): float
    {
        return $this->tarifa;
    }

    public function setTarifa(float $tarifa): self
    {
        $this->tarifa = $tarifa;
        return $this;
    }

    public function getCHora(): float
    {
        return $this->cHora;
    }

    public function setCHora(float $cHora): self
    {
        $this->cHora = $cHora;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getTotalCost(): float
    {
        return $this->tarifa * $this->cHora;
    }
}
