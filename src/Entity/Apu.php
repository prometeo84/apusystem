<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'apu')]
class Apu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tenant::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tenant $tenant = null;

    #[ORM\ManyToOne(targetEntity: Projects::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Projects $proyecto = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $codigo = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $unidad = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $cantidad = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $rendimiento = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $costoUnitario = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    private ?string $costoTotal = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(?Tenant $tenant): self
    {
        $this->tenant = $tenant;
        return $this;
    }

    public function getProyecto(): ?Projects
    {
        return $this->proyecto;
    }

    public function setProyecto(?Projects $proyecto): self
    {
        $this->proyecto = $proyecto;
        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getUnidad(): ?string
    {
        return $this->unidad;
    }

    public function setUnidad(string $unidad): self
    {
        $this->unidad = $unidad;
        return $this;
    }

    public function getCantidad(): ?string
    {
        return $this->cantidad;
    }

    public function setCantidad(?string $cantidad): self
    {
        $this->cantidad = $cantidad;
        return $this;
    }

    public function getRendimiento(): ?string
    {
        return $this->rendimiento;
    }

    public function setRendimiento(?string $rendimiento): self
    {
        $this->rendimiento = $rendimiento;
        return $this;
    }

    public function getCostoUnitario(): ?string
    {
        return $this->costoUnitario;
    }

    public function setCostoUnitario(?string $costoUnitario): self
    {
        $this->costoUnitario = $costoUnitario;
        return $this;
    }

    public function getCostoTotal(): ?string
    {
        return $this->costoTotal;
    }

    public function setCostoTotal(?string $costoTotal): self
    {
        $this->costoTotal = $costoTotal;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
