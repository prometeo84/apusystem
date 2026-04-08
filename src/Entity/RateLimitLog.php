<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'rate_limit_logs', indexes: [
    new ORM\Index(name: 'idx_identifier_endpoint', columns: ['identifier', 'endpoint', 'window_end']),
    new ORM\Index(name: 'idx_window_end', columns: ['window_end'])
])]
class RateLimitLog
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $identifier;

    #[ORM\Column(type: 'string', length: 255)]
    private string $endpoint;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $attempts = 1;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $window_start = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $window_end;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $exceeded_at = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $created_at = null;

    public function __construct(string $identifier, string $endpoint, \DateTimeInterface $window_end)
    {
        $this->identifier = $identifier;
        $this->endpoint = $endpoint;
        $this->window_start = new \DateTimeImmutable();
        $this->window_end = $window_end;
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
