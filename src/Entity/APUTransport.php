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
    private string $descripcion;

    #[ORM\Column(type: 'string', length: 50)]
    private string $unidad;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 4)]
    private float $cantidad; // CANTIDAD

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $dmt; // DMT (km) - Distancia Media de Transporte

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $tarifaKm; // Tarifa por kilómetro

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

    public function getUnidad(): string
    {
        return $this->unidad;
    }

    public function setUnidad(string $unidad): self
    {
        $this->unidad = $unidad;
        return $this;
    }

    public function getCantidad(): float
    {
        return $this->cantidad;
    }

    public function setCantidad(float $cantidad): self
    {
        $this->cantidad = $cantidad;
        return $this;
    }

    public function getDmt(): float
    {
        return $this->dmt;
    }

    public function setDmt(float $dmt): self
    {
        $this->dmt = $dmt;
        return $this;
    }

    public function getTarifaKm(): float
    {
        return $this->tarifaKm;
    }

    public function setTarifaKm(float $tarifaKm): self
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
        return $this->cantidad * $this->dmt * $this->tarifaKm;
    }
}
