<?php

declare(strict_types=1);

namespace App\Api\DataTransformer\MarketPartner;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Api\Dto\MarketPartner\MarketPartnerAllResponse;
use App\Entity\MarketPartner;

class MarketPartnerAllOutputDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = []): MarketPartnerAllResponse
    {
        /** @var MarketPartner $object */
        $mp = new MarketPartnerAllResponse();
        $mp->partnerId = $object->getPartnerId();
        $mp->isActive = $object->getActive();

        return $mp;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $to === MarketPartnerAllResponse::class && $data instanceof MarketPartner;
    }
}
