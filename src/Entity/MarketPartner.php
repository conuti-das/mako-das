<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MarketPartnerRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarketPartnerRepository::class)]
class MarketPartner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $active;

    #[ORM\Column(type: 'integer')]
    private int $deleted;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $updatedAt;

    #[ORM\Column(type: 'json')]
    private array $type = [];

    #[ORM\Column(type: 'json')]
    private array $energy = [];

    #[ORM\Column(type: 'string')]
    private string $partnerId;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $partnerIdType = [];

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

    #[ORM\Column(type: 'integer')]
    private int $sign;

    #[ORM\Column(type: 'integer')]
    private int $compress;

    #[ORM\Column(type: 'integer')]
    private int $encrypt;

    #[ORM\Column(type: 'string', length: 255)]
    private string $reminderEmailAddress;

    #[ORM\Column(type: 'integer')]
    private int $usingTumCatalog;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $aboDARef;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $aboBgmNr;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $aboSendDate;

    #[ORM\Column(type: 'integer')]
    private int $syncNotWithMaster;

    public function getId(): int
    {
        return $this->id;
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

    public function getType(): array
    {
        return $this->type;
    }

    public function setType(array $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEnergy(): array
    {
        return $this->energy;
    }

    public function setEnergy(array $energy): self
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

    public function getPartnerIdType(): ?array
    {
        return $this->partnerIdType;
    }

    public function setPartnerIdType(?array $partnerIdType): self
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

    public function getAboDARef(): ?string
    {
        return $this->aboDARef;
    }

    public function setAboDARef(?string $aboDARef): self
    {
        $this->aboDARef = $aboDARef;

        return $this;
    }

    public function getAboBgmNr(): ?string
    {
        return $this->aboBgmNr;
    }

    public function setAboBgmNr(?string $aboBgmNr): self
    {
        $this->aboBgmNr = $aboBgmNr;

        return $this;
    }

    public function getAboSendDate(): ?DateTimeInterface
    {
        return $this->aboSendDate;
    }

    public function setAboSendDate(?DateTimeInterface $aboSendDate): self
    {
        $this->aboSendDate = $aboSendDate;

        return $this;
    }

    public function getSyncNotWithMaster(): int
    {
        return $this->syncNotWithMaster;
    }

    public function setSyncNotWithMaster(int $syncNotWithMaster): self
    {
        $this->syncNotWithMaster = $syncNotWithMaster;

        return $this;
    }
}
