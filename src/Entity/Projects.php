<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;

#[ORM\Entity]
#[ORM\Table(name: 'projects')]
class Projects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tenant::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Tenant $tenant = null;

    #[ORM\Column(name: 'name', type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'name.required')]
    #[Assert\Length(max: 255)]
    #[Assert\Regex(pattern: '/^[\\p{L}\\s]+$/u', message: 'name.invalid')]
    private ?string $name = null;

    #[ORM\Column(name: 'code', type: 'string', length: 100)]
    #[Assert\NotBlank(message: 'code.required')]
    #[Assert\Length(max: 100)]
    #[Assert\Regex(pattern: '/^[A-Za-z0-9]+$/', message: 'code.invalid')]
    private ?string $code = null;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'client_name', type: 'string', length: 255, nullable: true)]
    private ?string $client = null;

    #[ORM\Column(name: 'location', type: 'string', length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(name: 'start_date', type: 'date', nullable: true)]
    #[Assert\NotBlank(message: 'start_date.required')]
    #[Assert\Type(
        type: \DateTimeInterface::class,
        message: 'start_date.invalid'
    )]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(name: 'end_date', type: 'date', nullable: true)]
    #[Assert\NotBlank(message: 'end_date.required')]
    #[Assert\Type(
        type: \DateTimeInterface::class,
        message: 'end_date.invalid'
    )]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(name: 'status', type: 'string', length: 50)]
    #[Assert\NotBlank(message: 'status.required')]
    private string $status = 'planificacion'; // planificacion, en_proceso, pausado, finalizado

    #[ORM\Column(name: 'total_budget', type: 'decimal', precision: 15, scale: 2, nullable: true)]
    #[Assert\NotBlank(message: 'total_budget.required')]
    #[Assert\Regex(pattern: '/^\d+(\.\d{1,2})?$/', message: 'total_budget.invalid')]
    private ?string $totalBudget = null;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(name: 'updated_at', type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(targetEntity: Template::class, mappedBy: 'project', cascade: ['remove'])]
    #[ORM\OrderBy(['createdAt' => 'ASC'])]
    private Collection $templates;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'created_by', nullable: true, onDelete: 'SET NULL')]
    private ?User $createdBy = null;


    public function __construct()
    {
        $this->templates = new ArrayCollection();
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
        if ($tenant !== null && !$tenant->getProjects()->contains($this)) {
            $tenant->getProjects()->add($this);
        }
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(?string $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getTotalBudget(): ?string
    {
        return $this->totalBudget;
    }

    public function setTotalBudget(?string $totalBudget): self
    {
        $this->totalBudget = $totalBudget;
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

    public function getTemplates(): Collection
    {
        return $this->templates;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $user): self
    {
        $this->createdBy = $user;
        return $this;
    }

    /** Total budget calculated summing all templates */
    public function getCalculatedTotal(): float
    {
        $total = 0.0;
        foreach ($this->templates as $template) {
            $total += $template->getTotalBudget();
        }
        return $total;
    }
}
