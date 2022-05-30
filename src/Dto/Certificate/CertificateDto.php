<?php

declare(strict_types=1);

namespace App\Dto\Certificate;

use DateTime;
use DateTimeInterface;
use JsonException;

class CertificateDto
{
    private string $name;
    private string $hash;
    private string $serialNumber;
    private string $emailAddress;
    private DateTimeInterface $validFrom;
    private DateTimeInterface $validUntil;
    private string $subjectName;
    private string $subjectOrganisation;
    private string $subjectLocation;
    private string $subjectCountry;
    private string $issuerName;
    private string $issuerOrganisation;
    private string $issuerOrganisationUnit;
    private string $issuerCountry;
    private ?string $certificateFile = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getValidFrom(): DateTimeInterface
    {
        return $this->validFrom;
    }

    public function setValidFrom(DateTimeInterface $validFrom): self
    {
        $this->validFrom = $validFrom;

        return $this;
    }

    public function getValidUntil(): DateTimeInterface
    {
        return $this->validUntil;
    }

    public function setValidUntil(DateTimeInterface $validUntil): self
    {
        $this->validUntil = $validUntil;

        return $this;
    }

    public function getSubjectName(): string
    {
        return $this->subjectName;
    }

    public function setSubjectName(string $subjectName): self
    {
        $this->subjectName = $subjectName;

        return $this;
    }

    public function getSubjectOrganisation(): string
    {
        return $this->subjectOrganisation;
    }

    public function setSubjectOrganisation(string $subjectOrganisation): self
    {
        $this->subjectOrganisation = $subjectOrganisation;

        return $this;
    }

    public function getSubjectLocation(): string
    {
        return $this->subjectLocation;
    }

    public function setSubjectLocation(string $subjectLocation): self
    {
        $this->subjectLocation = $subjectLocation;

        return $this;
    }

    public function getSubjectCountry(): string
    {
        return $this->subjectCountry;
    }

    public function setSubjectCountry(string $subjectCountry): self
    {
        $this->subjectCountry = $subjectCountry;

        return $this;
    }

    public function getIssuerName(): string
    {
        return $this->issuerName;
    }

    public function setIssuerName(string $issuerName): self
    {
        $this->issuerName = $issuerName;

        return $this;
    }

    public function getIssuerOrganisation(): string
    {
        return $this->issuerOrganisation;
    }

    public function setIssuerOrganisation(string $issuerOrganisation): self
    {
        $this->issuerOrganisation = $issuerOrganisation;

        return $this;
    }

    public function getIssuerOrganisationUnit(): string
    {
        return $this->issuerOrganisationUnit;
    }

    public function setIssuerOrganisationUnit(string $issuerOrganisationUnit): self
    {
        $this->issuerOrganisationUnit = $issuerOrganisationUnit;

        return $this;
    }

    public function getIssuerCountry(): string
    {
        return $this->issuerCountry;
    }

    public function setIssuerCountry(string $issuerCountry): self
    {
        $this->issuerCountry = $issuerCountry;

        return $this;
    }

    public function isActive(): bool
    {
        $nowDate = new DateTime('now');

        return $this->getValidFrom() <= $nowDate && $this->getValidUntil() >= $nowDate;
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function toJson(): string
    {
        $objectVars = get_object_vars($this);
        $objectVars['isActive'] = $this->isActive();

        return json_encode($objectVars, JSON_THROW_ON_ERROR);
    }

    public function getCertificateFile(): ?string
    {
        return $this->certificateFile;
    }

    public function setCertificateFile(?string $certificateFile): self
    {
        $this->certificateFile = $certificateFile;

        return $this;
    }
}
