<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'items')]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tenant::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Tenant $tenant;

    #[ORM\Column(name: 'code', type: 'string', length: 100)]
    private string $codigo;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nombre;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(name: 'unit', type: 'string', length: 50)]
    private string $unidad;

    /** tipo: general | personalizado */
    #[ORM\Column(type: 'string', length: 20)]
    private string $tipo = 'personalizado';

    #[ORM\Column(type: 'boolean')]
    private bool $activo = true;

    #[ORM\OneToMany(targetEntity: TemplateItem::class, mappedBy: 'rubro', cascade: ['remove'])]
    private Collection $plantillaRubros;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->plantillaRubros = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

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

    public function getCodigo(): string
    {
        return $this->codigo;
    }
    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;
        return $this;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }
    public function setDescripcion(?string $d): self
    {
        $this->descripcion = $d;
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

    public function getTipo(): string
    {
        return $this->tipo;
    }
    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function isActivo(): bool
    {
        return $this->activo;
    }
    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;
        return $this;
    }

    public function getPlantillaRubros(): Collection
    {
        return $this->plantillaRubros;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(\DateTimeInterface $d): self
    {
        $this->updatedAt = $d;
        return $this;
    }
}
