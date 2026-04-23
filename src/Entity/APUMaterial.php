<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'apu_materials')]
#[ORM\HasLifecycleCallbacks]
class APUMaterial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: APUItem::class, inversedBy: 'materials')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?APUItem $apuItem = null;

    #[ORM\ManyToOne(targetEntity: Tenant::class)]
    #[ORM\JoinColumn(name: 'tenant_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Tenant $tenant = null;

    #[ORM\ManyToOne(targetEntity: Projects::class)]
    #[ORM\JoinColumn(name: 'project_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Projects $project = null;

    #[ORM\ManyToOne(targetEntity: Template::class)]
    #[ORM\JoinColumn(name: 'template_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Template $template = null;

    #[ORM\ManyToOne(targetEntity: TemplateItem::class)]
    #[ORM\JoinColumn(name: 'template_item_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?TemplateItem $templateItem = null;

    #[ORM\ManyToOne(targetEntity: \App\Entity\Material::class)]
    #[ORM\JoinColumn(name: 'material_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?\App\Entity\Material $material = null;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 4)]
    private string $quantity;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 4)]
    private string $unitPrice;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 4, nullable: true)]
    private ?string $costTotal = null;

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
        if ($apuItem !== null && !$apuItem->getMaterials()->contains($this)) {
            $apuItem->addMaterial($this);
        }
        return $this;
    }

    public function getDescription(): string
    {
        if ($this->material !== null) return $this->material->getName();
        return '';
    }

    /**
     * Alias en español para compatibilidad con plantillas antiguas.
     * @return string
     */
    public function getUnidad(): string
    {
        if ($this->material !== null) return $this->material->getUnit();
        return '';
    }
    public function getMaterial(): ?\App\Entity\Material
    {
        return $this->material;
    }

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(?Tenant $t): self
    {
        $this->tenant = $t;
        return $this;
    }

    public function getProject(): ?Projects
    {
        return $this->project;
    }

    public function setProject(?Projects $p): self
    {
        $this->project = $p;
        return $this;
    }

    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    public function setTemplate(?Template $t): self
    {
        $this->template = $t;
        return $this;
    }

    public function getTemplateItem(): ?TemplateItem
    {
        return $this->templateItem;
    }

    public function setTemplateItem(?TemplateItem $ti): self
    {
        $this->templateItem = $ti;
        return $this;
    }

    public function setMaterial(?\App\Entity\Material $m): self
    {
        $this->material = $m;
        return $this;
    }

    public function getQuantity(): string
    {
        return $this->quantity;
    }

    /**
     * Alias en español para compatibilidad con plantillas antiguas.
     * @return string
     */
    public function getCantidad(): string
    {
        return $this->quantity;
    }

    /**
     * @param float|int|string $quantity
     */
    public function setQuantity(float|int|string $quantity): self
    {
        $this->quantity = (string) $quantity;
        return $this;
    }

    public function getUnitPrice(): string
    {
        return $this->unitPrice;
    }

    /**
     * Alias en español para compatibilidad con plantillas antiguas.
     * @return string
     */
    public function getPrecioUnitario(): string
    {
        return $this->unitPrice;
    }

    /**
     * @param float|int|string $unitPrice
     */
    public function setUnitPrice(float|int|string $unitPrice): self
    {
        $this->unitPrice = (string) $unitPrice;
        return $this;
    }

    public function getCostTotal(): ?string
    {
        return $this->costTotal;
    }

    public function setCostTotal(?string $v): self
    {
        $this->costTotal = $v;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getTotalCost(): float
    {
        // prefer persisted total if available
        if ($this->costTotal !== null) {
            return (float) $this->costTotal;
        }
        return (float) $this->quantity * (float) $this->unitPrice;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function calculatePersistedTotal(): void
    {
        $q = (float) $this->quantity;
        $p = (float) $this->unitPrice;
        $total = $q * $p;
        $this->costTotal = number_format($total, 4, '.', '');
    }
}
