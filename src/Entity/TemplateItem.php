<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'template_items')]
class TemplateItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Template::class, inversedBy: 'items')]
    #[ORM\JoinColumn(name: 'template_id', nullable: false, onDelete: 'CASCADE')]
    private Template $template;

    #[ORM\ManyToOne(targetEntity: Item::class, inversedBy: 'templateItems')]
    #[ORM\JoinColumn(name: 'item_id', nullable: false, onDelete: 'RESTRICT')]
    private Item $item;

    /** APU asociado a este rubro en esta plantilla (nullable: el rubro puede no tener APU aún) */
    #[ORM\OneToOne(targetEntity: APUItem::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'apu_item_id', nullable: true, onDelete: 'SET NULL')]
    private ?APUItem $apuItem = null;

    /** Quantity of the item in the template */
    #[ORM\Column(name: 'quantity', type: 'decimal', precision: 15, scale: 4)]
    private string $quantity = '1.0000';

    /** Display order in the template */
    // Use quoted column name because `order` is a reserved keyword in MySQL
    #[ORM\Column(name: '`order`', type: 'integer')]
    private int $order = 0;

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

    public function getTemplate(): Template
    {
        return $this->template;
    }
    public function setTemplate(Template $template): self
    {
        $this->template = $template;
        return $this;
    }

    public function getItem(): Item
    {
        return $this->item;
    }
    public function setItem(Item $item): self
    {
        $this->item = $item;
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

    public function getQuantity(): string
    {
        return $this->quantity;
    }
    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }
    public function setOrder(int $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /** Total cost of this item = quantity × APU unit price */
    public function getTotalCost(): float
    {
        if ($this->apuItem === null) {
            return 0.0;
        }
        return (float) $this->quantity * (float) $this->apuItem->getTotalCost();
    }

    /** Unit price of the APU (calculation price with profit) */
    public function getUnitPrice(): float
    {
        return $this->apuItem ? (float) $this->apuItem->getTotalCost() : 0.0;
    }
}
