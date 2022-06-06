<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MarketPartnerImportLogRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarketPartnerImportLogRepository::class)]
class MarketPartnerImportLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $status;

    #[ORM\Column(type: 'text', nullable: true)]
    private string $message;

    #[ORM\Column(type: 'date', nullable: true)]
    private DateTimeInterface $createdAt;

    #[ORM\ManyToOne(targetEntity: MarketPartner::class, inversedBy: 'marketPartnerImportLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private $marketPartner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
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
