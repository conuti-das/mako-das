<?php

namespace App\Entity;

use App\Repository\MarketPartnerEmailImportLogRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarketPartnerEmailImportLogRepository::class)]
class MarketPartnerEmailImportLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $status;

    #[ORM\Column(type: 'text')]
    private string $message;

    #[ORM\Column(type: 'date', nullable: true)]
    private DateTimeInterface $createdAt;

    #[ORM\ManyToOne(targetEntity: MarketPartnerEmail::class, inversedBy: 'marketPartnerEmailImportLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private $marketPartnerEmail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message): self
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

    public function getMarketPartnerEmail(): ?MarketPartnerEmail
    {
        return $this->marketPartnerEmail;
    }

    public function setMarketPartnerEmail(?MarketPartnerEmail $marketPartnerEmail): self
    {
        $this->marketPartnerEmail = $marketPartnerEmail;

        return $this;
    }
}
