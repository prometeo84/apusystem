<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'webauthn_credentials', indexes: [new \Doctrine\ORM\Mapping\Index(name: 'idx_webauthn_user', columns: ['user_id'])])]
class WebAuthnCredential
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private User $user;

    #[ORM\Column(type: 'string', length: 255)]
    private string $credentialId;

    #[ORM\Column(type: 'text')]
    private string $publicKey;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $fmt = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $aaguid = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $transports = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $attestation = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    public function __construct(User $user, string $credentialId, string $publicKey)
    {
        $this->user = $user;
        $this->credentialId = $credentialId;
        $this->publicKey = $publicKey;
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCredentialId(): string
    {
        return $this->credentialId;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getFmt(): ?string
    {
        return $this->fmt;
    }

    public function setFmt(?string $fmt): self
    {
        $this->fmt = $fmt;
        return $this;
    }

    public function getAaguid(): ?string
    {
        return $this->aaguid;
    }

    public function setAaguid(?string $aaguid): self
    {
        $this->aaguid = $aaguid;
        return $this;
    }

    public function getTransports(): ?string
    {
        return $this->transports;
    }

    public function setTransports(?string $transports): self
    {
        $this->transports = $transports;
        return $this;
    }

    public function getAttestation(): ?string
    {
        return $this->attestation;
    }

    public function setAttestation(?string $attestation): self
    {
        $this->attestation = $attestation;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
