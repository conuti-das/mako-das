<?php

declare(strict_types=1);

namespace App\Api\Dto\MarketPartnerEmail;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class MarketPartnerEmailAllResponse
{
    #[Groups(["market-partners-email-all:read"])]
    public int $marketPartnerId;

    #[Groups(["market-partners-email-all:read"])]
    public string $email;

    #[Groups(["market-partners-email-all:read"])]
    public string $type;

    #[Groups(["market-partners-email-all:read"])]
    public string $sslCertificate;

    #[Groups(["market-partners-email-all:read"])]
    public DateTimeInterface $sslCertificateExpiration;

    #[Groups(["market-partners-email-all:read"])]
    public DateTimeInterface $activeFrom;

    #[Groups(["market-partners-email-all:read"])]
    public DateTimeInterface $activeUntil;
}
