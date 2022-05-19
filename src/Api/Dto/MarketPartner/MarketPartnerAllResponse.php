<?php

declare(strict_types=1);

namespace App\Api\Dto\MarketPartner;

use Symfony\Component\Serializer\Annotation\Groups;

class MarketPartnerAllResponse
{
    #[Groups(["market-partners-all:read"])]
    public string $partnerId;

    #[Groups(["market-partners-all:read"])]
    public int $isActive;
}
