<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MarketPartnerEmailImportLogRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarketPartnerEmailImportLogRepository::class)]
class MarketPartnerEmailImportLog
{
    public const STATUS_DONE = "done";
    public const STATUS_FAILED = "failed";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $status;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $message;

    #[ORM\Column(type: 'date')]
    private DateTimeInterface $createdAt;

    #[ORM\ManyToOne(targetEntity: MarketPartnerEmail::class, inversedBy: 'marketPartnerEmailImportLogs')]
    #[ORM\JoinColumn(nullable: true)]
    private ?MarketPartnerEmail $marketPartnerEmail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getMarketPartnerEmail(): ?MarketPartnerEmail
    {
        return $this->marketPartnerEmail;
    }

    public function setMarketPartnerEmail(?MarketPartnerEmail $marketPartnerEmail): void
    {
        $this->marketPartnerEmail = $marketPartnerEmail;
    }
}
