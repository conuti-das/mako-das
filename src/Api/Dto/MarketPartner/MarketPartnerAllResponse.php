<?php

declare(strict_types=1);

namespace App\Api\Dto\MarketPartner;

use App\Entity\MarketPartner;
use Symfony\Component\Serializer\Annotation\Groups;

class MarketPartnerAllResponse
{
    #[Groups(["market-partners-all:read"])]
    public string $partnerId;

    #[Groups(["market-partners-all:read"])]
    public int $isActive;
/**
    #[Groups(["market-partners-all:read"])]
    private string $type;

    #[Groups(["market-partners-all:read"])]
    private string $energy;

    #[Groups(["market-partners-all:read"])]
    private ?string $partnerIdType;

    #[Groups(["market-partners-all:read"])]
    private ?string $partnerIdGmsb;

    #[Groups(["market-partners-all:read"])]
    private string $organization;
*/
}
