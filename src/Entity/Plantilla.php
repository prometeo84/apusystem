<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'plantillas')]
class Plantilla
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tenant::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Tenant $tenant;

    #[ORM\ManyToOne(targetEntity: Projects::class, inversedBy: 'plantillas')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Projects $proyecto;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nombre;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(type: 'boolean')]
    private bool $activa = true;

    #[ORM\OneToMany(targetEntity: PlantillaRubro::class, mappedBy: 'plantilla', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['orden' => 'ASC'])]
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

    public function getProyecto(): Projects
    {
        return $this->proyecto;
    }
    public function setProyecto(Projects $proyecto): self
    {
        $this->proyecto = $proyecto;
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

    public function isActiva(): bool
    {
        return $this->activa;
    }
    public function setActiva(bool $activa): self
    {
        $this->activa = $activa;
        return $this;
    }

    public function getPlantillaRubros(): Collection
    {
        return $this->plantillaRubros;
    }

    /** Total presupuesto = suma de todos los costos de los rubros */
    public function getTotalPresupuesto(): float
    {
        $total = 0.0;
        foreach ($this->plantillaRubros as $pr) {
            $total += $pr->getTotalCosto();
        }
        return $total;
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
