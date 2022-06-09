<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Api\Dto\MarketPartner\MarketPartnerAllResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\MarketPartnerRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations: [
        'market_partners_all' => [
            'method' => 'GET',
            'path'=>'/market-partners',
            'output' => MarketPartnerAllResponse::class,
            'normalization_context' => ['groups' => ['market-partners-all:read']],
        ],
    ],
    itemOperations: [
        'market_partners_single' => [
            'method' => 'GET',
            'path'=>'/market-partners/{id}',
        ],
    ],
)]
#[ORM\Entity(repositoryClass: MarketPartnerRepository::class)]
class MarketPartner
{
    public const TYPE_NET = 'net';
    public const TYPE_PROVIDER = 'provider';
    public const TYPE_MSB = 'msb';
    public const TYPE_TSO = 'tso';

    public const ENERGY_ELECTRICITY = 'electricity';
    public const ENERGY_GAS = 'gas';
    public const ENERGY_WATER_SEWAGE = 'water_sewage';

    public const NUMBER_BDEW = 'bdew';
    public const NUMBER_ILN = 'iln';
    public const NUMBER_DVGW = 'dvgw';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer', length: 1)]
    private int $active;

    #[ORM\Column(type: 'integer', length: 1)]
    private int $deleted;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $updatedAt;

    #[ORM\Column(type: 'string')]
    private string $type;

    #[ORM\Column(type: 'string')]
    private string $energy;

    #[ORM\Column(type: 'string')]
    #[Groups(["market-partners-email-all:read"])]
    private string $partnerId;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $partnerIdType;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $partnerIdGmsb;

    #[ORM\Column(type: 'string', length: 255)]
    private string $organization;

    #[ORM\Column(type: 'string')]
    private string $zip;

    #[ORM\Column(type: 'string', length: 100)]
    private string $city;

    #[ORM\Column(type: 'string', length: 100)]
    private string $street;

    #[ORM\Column(type: 'string', length: 35, nullable: true)]
    private ?string $houseNumber;

    #[ORM\Column(type: 'string', length: 34, nullable: true)]
    private ?string $iban;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private ?string $bic;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private ?string $bank;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $accountHolder;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $phone;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $registerCourt;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $registerNumber;

    #[ORM\Column(type: 'integer', length: 1)]
    private int $sign;

    #[ORM\Column(type: 'integer', length: 1)]
    private int $compress;

    #[ORM\Column(type: 'integer', length: 1)]
    private int $encrypt;

    #[ORM\Column(type: 'string', length: 255)]
    private string $reminderEmailAddress;

    #[ORM\Column(type: 'integer', length: 1)]
    private int $usingTumCatalog;

    #[ORM\OneToMany(mappedBy: 'marketPartner', targetEntity: MarketPartnerEmail::class)]
    private Collection $marketPartnerEmails;

    #[ORM\OneToMany(mappedBy: 'marketPartner', targetEntity: MarketPartnerImportLog::class)]
    private Collection $marketPartnerImportLogs;

    public function __construct()
    {
        $this->marketPartnerEmails = new ArrayCollection();
        $this->marketPartnerImportLogs = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getDeleted(): int
    {
        return $this->deleted;
    }

    public function setDeleted(int $deleted): self
    {
        $this->deleted = $deleted;

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

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getEnergy(): string
    {
        return $this->energy;
    }

    public function setEnergy(string $energy): self
    {
        $this->energy = $energy;

        return $this;
    }

    public function getPartnerId(): string
    {
        return $this->partnerId;
    }

    public function setPartnerId(string $partnerId): self
    {
        $this->partnerId = $partnerId;

        return $this;
    }

    public function getPartnerIdType(): ?string
    {
        return $this->partnerIdType;
    }

    public function setPartnerIdType(?string $partnerIdType): self
    {
        $this->partnerIdType = $partnerIdType;

        return $this;
    }

    public function getPartnerIdGmsb(): ?string
    {
        return $this->partnerIdGmsb;
    }

    public function setPartnerIdGmsb(?string $partnerIdGmsb): self
    {
        $this->partnerIdGmsb = $partnerIdGmsb;

        return $this;
    }

    public function getOrganization(): string
    {
        return $this->organization;
    }

    public function setOrganization(string $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(?string $houseNumber): self
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(?string $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function setBic(?string $bic): self
    {
        $this->bic = $bic;

        return $this;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(?string $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    public function getAccountHolder(): ?string
    {
        return $this->accountHolder;
    }

    public function setAccountHolder(?string $accountHolder): self
    {
        $this->accountHolder = $accountHolder;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getRegisterCourt(): ?string
    {
        return $this->registerCourt;
    }

    public function setRegisterCourt(?string $registerCourt): self
    {
        $this->registerCourt = $registerCourt;

        return $this;
    }

    public function getRegisterNumber(): ?string
    {
        return $this->registerNumber;
    }

    public function setRegisterNumber(?string $registerNumber): self
    {
        $this->registerNumber = $registerNumber;

        return $this;
    }

    public function getSign(): int
    {
        return $this->sign;
    }

    public function setSign(int $sign): self
    {
        $this->sign = $sign;

        return $this;
    }

    public function getCompress(): int
    {
        return $this->compress;
    }

    public function setCompress(int $compress): self
    {
        $this->compress = $compress;

        return $this;
    }

    public function getEncrypt(): int
    {
        return $this->encrypt;
    }

    public function setEncrypt(int $encrypt): self
    {
        $this->encrypt = $encrypt;

        return $this;
    }

    public function getReminderEmailAddress(): string
    {
        return $this->reminderEmailAddress;
    }

    public function setReminderEmailAddress(string $reminderEmailAddress): self
    {
        $this->reminderEmailAddress = $reminderEmailAddress;

        return $this;
    }

    public function getUsingTumCatalog(): int
    {
        return $this->usingTumCatalog;
    }

    public function setUsingTumCatalog(int $usingTumCatalog): self
    {
        $this->usingTumCatalog = $usingTumCatalog;

        return $this;
    }

    public function getMarketPartnerEmails(): Collection
    {
        return $this->marketPartnerEmails;
    }

    public function addMarketPartnerEmail(MarketPartnerEmail $marketPartnerEmail): self
    {
        if (!$this->marketPartnerEmails->contains($marketPartnerEmail)) {
            $this->marketPartnerEmails[] = $marketPartnerEmail;
            $marketPartnerEmail->setMarketPartner($this);
        }

        return $this;
    }

    public function removeMarketPartnerEmail(MarketPartnerEmail $marketPartnerEmail): self
    {
        if ($this->marketPartnerEmails->removeElement($marketPartnerEmail)) {
            if ($marketPartnerEmail->getMarketPartner() === $this) {
                $marketPartnerEmail->setMarketPartner(null);
            }
        }

        return $this;
    }

    public function getMarketPartnerImportLogs(): Collection
    {
        return $this->marketPartnerImportLogs;
    }

    public function addMarketPartnerImportLog(MarketPartnerImportLog $marketPartnerImportLog): self
    {
        if (!$this->marketPartnerImportLogs->contains($marketPartnerImportLog)) {
            $this->marketPartnerImportLogs[] = $marketPartnerImportLog;
            $marketPartnerImportLog->setMarketPartner($this);
        }

        return $this;
    }

    public function removeMarketPartnerImportLog(MarketPartnerImportLog $marketPartnerImportLog): self
    {
        if ($this->marketPartnerImportLogs->removeElement($marketPartnerImportLog)) {
            if ($marketPartnerImportLog->getMarketPartner() === $this) {
                $marketPartnerImportLog->setMarketPartner(null);
            }
        }

        return $this;
    }
}
