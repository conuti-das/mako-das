<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MarketMessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarketMessageRepository::class)]
#[ApiResource]
class MarketMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[ApiProperty(identifier: false)]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $status;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updatedAt;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private $sender;

    #[ORM\Column(type: 'string', length: 15)]
    private $receiver;

    #[ORM\Column(type: 'string', length: 35, nullable: true)]
    private $reference;

    #[ORM\Column(type: 'string', length: 10)]
    private $type;

    #[ORM\Column(type: 'string', length: 7, nullable: true)]
    private $businessTransaction;

    #[ORM\Column(type: 'string', length: 5)]
    private $direction;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[ApiProperty(identifier: true)]
    private $businessKey;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $processKey;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $processId;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nifiId;

    #[ORM\Column(type: 'string', length: 2048, nullable: true)]
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(?string $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?string
    {
        return $this->receiver;
    }

    public function setReceiver(string $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBusinessTransaction(): ?string
    {
        return $this->businessTransaction;
    }

    public function setBusinessTransaction(?string $businessTransaction): self
    {
        $this->businessTransaction = $businessTransaction;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): self
    {
        $this->direction = $direction;

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

    public function getBusinessKey(): ?string
    {
        return $this->businessKey;
    }

    public function setBusinessKey(?string $businessKey): self
    {
        $this->businessKey = $businessKey;

        return $this;
    }

    public function getProcessKey(): ?string
    {
        return $this->processKey;
    }

    public function setProcessKey(?string $processKey): self
    {
        $this->processKey = $processKey;

        return $this;
    }

    public function getProcessId(): ?int
    {
        return $this->processId;
    }

    public function setProcessId(?int $processId): self
    {
        $this->processId = $processId;

        return $this;
    }

    public function getNifiId(): ?string
    {
        return $this->nifiId;
    }

    public function setNifiId(?string $nifiId): self
    {
        $this->nifiId = $nifiId;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
