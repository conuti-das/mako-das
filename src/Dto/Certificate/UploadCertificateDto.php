<?php

declare(strict_types=1);

namespace App\Dto\Certificate;

use App\Entity\MarketPartner;
use DateTimeInterface;

class UploadCertificateDto implements CertificateDtoInterface
{
    private string $emailAddress;
    private DateTimeInterface $validFrom;
    private DateTimeInterface $validUntil;
    private string $certificateFile;
    private MarketPartner $marketPartner;

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

    public function getCertificateFile(): string
    {
        return $this->certificateFile;
    }

    public function setCertificateFile(string $certificateFile): self
    {
        $this->certificateFile = $certificateFile;

        return $this;
    }

    public function setMarketPartner(MarketPartner $marketPartner): self
    {
        $this->marketPartner = $marketPartner;

        return $this;
    }

    public function getMarketPartner(): MarketPartner
    {
        return $this->marketPartner;
    }
}
