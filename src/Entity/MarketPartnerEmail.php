<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use App\Api\Dto\MarketPartnerEmail\MarketPartnerEmailAllResponse;
use App\Repository\MarketPartnerEmailRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    collectionOperations: [
        'market_partners_email' => [
            'method' => 'GET',
            'path'=>'/market-partners-email',
            'output' => MarketPartnerEmailAllResponse::class,
            'normalization_context' => ['groups' => ['market-partners-email-all:read']],
        ],
    ],
    itemOperations: [
        'market_partners_email_single' => [
            'method' => 'GET',
            'path'=>'/market-partners-email',
        ],
    ],
)]
#[ApiFilter(DateFilter::class, properties: ['updatedAt'])]
#[ORM\Entity(repositoryClass: MarketPartnerEmailRepository::class)]
class MarketPartnerEmail
{
    public const TYPE_EDIFACT = 'edifact';
    public const TYPE_REMINDER = 'reminder';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $marketPartnerId;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $updatedAt;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'string')]
    private string $type;

    #[ORM\Column(type: 'text', nullable: true)]
    private string $sslCertificate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $sslCertificateExpiration;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $activeFrom;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $activeUntil;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getMarketPartnerId(): int
    {
        return $this->marketPartnerId;
    }

    public function setMarketPartnerId(int $marketPartnerId): self
    {
        $this->marketPartnerId = $marketPartnerId;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSslCertificate(): string
    {
        return $this->sslCertificate;
    }

    public function setSslCertificate(string $sslCertificate): self
    {
        $this->sslCertificate = $sslCertificate;

        return $this;
    }

    public function getSslCertificateExpiration(): ?DateTimeInterface
    {
        return $this->sslCertificateExpiration;
    }

    public function setSslCertificateExpiration(?DateTimeInterface $sslCertificateExpiration): self
    {
        $this->sslCertificateExpiration = $sslCertificateExpiration;

        return $this;
    }

    public function getActiveFrom(): DateTimeInterface
    {
        return $this->activeFrom;
    }

    public function setActiveFrom(DateTimeInterface $activeFrom): self
    {
        $this->activeFrom = $activeFrom;

        return $this;
    }

    public function getActiveUntil(): ?DateTimeInterface
    {
        return $this->activeUntil;
    }

    public function setActiveUntil(?DateTimeInterface $activeUntil): self
    {
        $this->activeUntil = $activeUntil;

        return $this;
    }
}
