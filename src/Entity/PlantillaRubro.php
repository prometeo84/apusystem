<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'plantilla_rubros')]
class PlantillaRubro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Plantilla::class, inversedBy: 'plantillaRubros')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Plantilla $plantilla;

    #[ORM\ManyToOne(targetEntity: Rubro::class, inversedBy: 'plantillaRubros')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'RESTRICT')]
    private Rubro $rubro;

    /** APU asociado a este rubro en esta plantilla (nullable: el rubro puede no tener APU aún) */
    #[ORM\OneToOne(targetEntity: APUItem::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?APUItem $apuItem = null;

    /** Cantidad del rubro en el presupuesto */
    #[ORM\Column(type: 'decimal', precision: 15, scale: 4)]
    private string $cantidad = '1.0000';

    /** Orden de aparición en la plantilla */
    #[ORM\Column(type: 'integer')]
    private int $orden = 0;

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

    public function getPlantilla(): Plantilla
    {
        return $this->plantilla;
    }
    public function setPlantilla(Plantilla $plantilla): self
    {
        $this->plantilla = $plantilla;
        return $this;
    }

    public function getRubro(): Rubro
    {
        return $this->rubro;
    }
    public function setRubro(Rubro $rubro): self
    {
        $this->rubro = $rubro;
        return $this;
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

    public function getCantidad(): string
    {
        return $this->cantidad;
    }
    public function setCantidad(string $cantidad): self
    {
        $this->cantidad = $cantidad;
        return $this;
    }

    public function getOrden(): int
    {
        return $this->orden;
    }
    public function setOrden(int $orden): self
    {
        $this->orden = $orden;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /** Costo total de este rubro = cantidad × precio unitario del APU */
    public function getTotalCosto(): float
    {
        if ($this->apuItem === null) {
            return 0.0;
        }
        return (float) $this->cantidad * (float) $this->apuItem->getTotalCost();
    }

    /** Precio unitario del APU (precio de cálculo con utilidad) */
    public function getPrecioUnitario(): float
    {
        return $this->apuItem ? (float) $this->apuItem->getTotalCost() : 0.0;
    }
}
