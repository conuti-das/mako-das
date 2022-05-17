<?php

namespace App\Entity;

use App\Repository\MarketPartnerEmailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarketPartnerEmailRepository::class)]
class MarketPartnerEmail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $marketPartnerId;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $type = [];

    #[ORM\Column(type: 'text', nullable: true)]
    private $sslCertificate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $sslCertificateExpiration;

    #[ORM\Column(type: 'datetime')]
    private $activeFrom;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $activeUntil;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarketPartnerId(): ?int
    {
        return $this->marketPartnerId;
    }

    public function setMarketPartnerId(int $marketPartnerId): self
    {
        $this->marketPartnerId = $marketPartnerId;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getType(): ?array
    {
        return $this->type;
    }

    public function setType(array $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSslCertificate(): ?string
    {
        return $this->sslCertificate;
    }

    public function setSslCertificate(?string $sslCertificate): self
    {
        $this->sslCertificate = $sslCertificate;

        return $this;
    }

    public function getSslCertificateExpiration(): ?\DateTimeInterface
    {
        return $this->sslCertificateExpiration;
    }

    public function setSslCertificateExpiration(?\DateTimeInterface $sslCertificateExpiration): self
    {
        $this->sslCertificateExpiration = $sslCertificateExpiration;

        return $this;
    }

    public function getActiveFrom(): ?\DateTimeInterface
    {
        return $this->activeFrom;
    }

    public function setActiveFrom(\DateTimeInterface $activeFrom): self
    {
        $this->activeFrom = $activeFrom;

        return $this;
    }

    public function getActiveUntil(): ?\DateTimeInterface
    {
        return $this->activeUntil;
    }

    public function setActiveUntil(?\DateTimeInterface $activeUntil): self
    {
        $this->activeUntil = $activeUntil;

        return $this;
    }
}
