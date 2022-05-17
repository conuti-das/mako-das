<?php

namespace App\Entity;

use App\Repository\MarketPartnerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\IsNull;

#[ORM\Entity(repositoryClass: MarketPartnerRepository::class)]
class MarketPartner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $active;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $deleted;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'json')]
    private $type = [];

    #[ORM\Column(type: 'json')]
    private $energy = [];

    #[ORM\Column(type: 'bigint')]
    private $partnerId;

    #[ORM\Column(type: 'json', nullable: true)]
    private $partnerIdType = [];

    #[ORM\Column(type: 'bigint', nullable: true)]
    private $partnerIdGmsb;

    #[ORM\Column(type: 'string', length: 255)]
    private $organization;

    #[ORM\Column(type: 'integer')]
    private $zip;

    #[ORM\Column(type: 'string', length: 100)]
    private $city;

    #[ORM\Column(type: 'string', length: 100)]
    private $street;

    #[ORM\Column(type: 'string', length: 35, nullable: true)]
    private $houseNumber;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $accountId;

    #[ORM\Column(type: 'string', length: 34, nullable: true)]
    private $iban;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private $bic;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $bank;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $accountHolder;

    #[ORM\Column(type: 'string', length: 70, nullable: true)]
    private $phone;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $registerCourt;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $registerNumber;

    #[ORM\Column(type: 'integer')]
    private $sign;

    #[ORM\Column(type: 'integer')]
    private $compress;

    #[ORM\Column(type: 'integer')]
    private $encrypt;

    #[ORM\Column(type: 'string', length: 255)]
    private $reminderEmailAddress;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $usingTumCatalog;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $aboDARef;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $aboBgmNr;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $aboSendDate;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $aboIsSent;

    #[ORM\Column(type: 'integer')]
    private $lockPayoutsRemadv;

    #[ORM\Column(type: 'integer')]
    private $syncNotWithMaster;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getDeleted(): ?int
    {
        return $this->deleted;
    }

    public function setDeleted(int $deleted): self
    {
        $this->deleted = $deleted;

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

    public function getType(): ?array
    {
        return $this->type;
    }

    public function setType(array $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEnergy(): ?array
    {
        return $this->energy;
    }

    public function setEnergy(array $energy): self
    {
        $this->energy = $energy;

        return $this;
    }

    public function getPartnerId(): ?string
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

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(string $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getZip(): ?int
    {
        return $this->zip;
    }

    public function setZip(int $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
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

    public function getAccountId(): ?int
    {
        return $this->accountId;
    }

    public function setAccountId(?int $accountId): self
    {
        $this->accountId = $accountId;

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

    public function getSign(): ?int
    {
        return $this->sign;
    }

    public function setSign(int $sign): self
    {
        $this->sign = $sign;

        return $this;
    }

    public function getCompress(): ?int
    {
        return $this->compress;
    }

    public function setCompress(int $compress): self
    {
        $this->compress = $compress;

        return $this;
    }

    public function getEncrypt(): ?int
    {
        return $this->encrypt;
    }

    public function setEncrypt(int $encrypt): self
    {
        $this->encrypt = $encrypt;

        return $this;
    }

    public function getReminderEmailAddress(): ?string
    {
        return $this->reminderEmailAddress;
    }

    public function setReminderEmailAddress(string $reminderEmailAddress): self
    {
        $this->reminderEmailAddress = $reminderEmailAddress;

        return $this;
    }

    public function getUsingTumCatalog(): ?int
    {
        return $this->usingTumCatalog;
    }

    public function setUsingTumCatalog(?int $usingTumCatalog): self
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

    public function getAboSendDate(): ?\DateTimeInterface
    {
        return $this->aboSendDate;
    }

    public function setAboSendDate(?\DateTimeInterface $aboSendDate): self
    {
        $this->aboSendDate = $aboSendDate;

        return $this;
    }

    public function getAboIsSent(): ?int
    {
        return $this->aboIsSent;
    }

    public function setAboIsSent(?int $aboIsSent): self
    {
        $this->aboIsSent = $aboIsSent;

        return $this;
    }

    public function getLockPayoutsRemadv(): ?int
    {
        return $this->lockPayoutsRemadv;
    }

    public function setLockPayoutsRemadv(int $lockPayoutsRemadv): self
    {
        $this->lockPayoutsRemadv = $lockPayoutsRemadv;

        return $this;
    }

    public function getSyncNotWithMaster(): ?int
    {
        return $this->syncNotWithMaster;
    }

    public function setSyncNotWithMaster(int $syncNotWithMaster): self
    {
        $this->syncNotWithMaster = $syncNotWithMaster;

        return $this;
    }
}
