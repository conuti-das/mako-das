<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MarketPartnerImportLogRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarketPartnerImportLogRepository::class)]
class MarketPartnerImportLog
{
    public const STATUS_DONE = "done";
    public const STATUS_FAILED = "failed";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $status;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $message;

    #[ORM\Column(type: 'date', nullable: false)]
    private DateTimeInterface $createdAt;

    #[ORM\ManyToOne(targetEntity: MarketPartner::class, inversedBy: 'marketPartnerImportLogs')]
    #[ORM\JoinColumn(nullable: true)]
    private ?MarketPartner $marketPartner;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

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

    public function getMarketPartner(): ?MarketPartner
    {
        return $this->marketPartner;
    }

    public function setMarketPartner(?MarketPartner $marketPartner): self
    {
        $this->marketPartner = $marketPartner;

        return $this;
    }
}
