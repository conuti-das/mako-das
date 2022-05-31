<?php

declare(strict_types=1);

namespace App\Api\DataTransformer\MarketPartnerEmail;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Api\Dto\MarketPartnerEmail\MarketPartnerEmailAllResponse;
use App\Entity\MarketPartnerEmail;

class MarketPartnerEmailAllOutputDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = []): MarketPartnerEmailAllResponse
    {
        /** @var MarketPartnerEmail $object */
        $mp = new MarketPartnerEmailAllResponse();
        $mp->marketPartnerId = $object->getMarketPartnerId();
        $mp->email = $object->getEmail();
        $mp->type = $object->getType();
        $mp->sslCertificate = $object->getSslCertificate();
        $mp->sslCertificateExpiration = $object->getSslCertificateExpiration();
        $mp->activeFrom = $object->getActiveFrom();
        $mp->activeUntil = $object->getActiveUntil();

        return $mp;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $to === MarketPartnerEmailAllResponse::class && $data instanceof MarketPartnerEmail;
    }
}
