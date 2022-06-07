<?php

declare(strict_types=1);

namespace App\Dto\Certificate;


use App\Entity\MarketPartner;
use DateTimeInterface;

interface CertificateDtoInterface
{
    public function getEmailAddress(): string;
    public function getValidFrom(): DateTimeInterface;
    public function getValidUntil(): DateTimeInterface;
    public function getCertificateFile(): string;
    public function getMarketPartner(): MarketPartner;
}
