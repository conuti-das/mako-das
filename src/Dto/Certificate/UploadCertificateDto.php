<?php

declare(strict_types=1);

namespace App\Dto\Certificate;

use DateTimeInterface;

class UploadCertificateDto
{
    private int $partnerId;
    private string $emailAddress;
    private DateTimeInterface $validFrom;
    private DateTimeInterface $validUntil;
    private string $certificateFile;

    public function getPartnerId(): int
    {
        return $this->partnerId;
    }

    public function setPartnerId(int $partnerId): self
    {
        $this->partnerId = $partnerId;

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

    public function getCertificateFile(): string
    {
        return $this->certificateFile;
    }

    public function setCertificateFile(string $certificateFile): self
    {
        $this->certificateFile = $certificateFile;

        return $this;
    }
}
