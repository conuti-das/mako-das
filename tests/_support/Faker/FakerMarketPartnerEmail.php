<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\MarketPartnerEmail;
use App\Tests\Exception\MarketPartner\MarketPartnerEmptyException;
use DateTime;

class FakerMarketPartnerEmail extends Faker
{
    public function create(?array $data): MarketPartnerEmail
    {
        if (!isset($data['marketPartner'])) {
            throw new MarketPartnerEmptyException("marketPartner not found");
        }

        $nowDate = new DateTime('now');
        $expiredDate = clone $nowDate->modify('+1 year');

        $marketPartnerEmail = new MarketPartnerEmail();
        $marketPartnerEmail->setId($data['id'] ?? 1);
        $marketPartnerEmail->setMarketPartner($data['marketPartner']);
        $marketPartnerEmail->setCreatedAt($data['createdAt'] ?? $nowDate);
        $marketPartnerEmail->setUpdatedAt($data['updatedAt'] ?? $nowDate);
        $marketPartnerEmail->setEmail($data['email'] ?? 'debug@conuti.de');
        $marketPartnerEmail->setType($data['type'] ?? MarketPartnerEmail::TYPE_EDIFACT);
        $marketPartnerEmail->setSslCertificate(
            $data['sslCertificate'] ?? 'rjh$ZaG+xbHUauc2p5PvwNhReQ==.fdd873cc2c87b844f972a4bfa086cbb0'
        );
        $marketPartnerEmail->setSslCertificateExpiration($data['sslCertificateExpiration'] ?? $expiredDate);
        $marketPartnerEmail->setActiveFrom($data['activeFrom'] ?? $nowDate);
        $marketPartnerEmail->setActiveUntil($data['activeUntil'] ?? $expiredDate);

        $this->entityManager->persist($marketPartnerEmail);
        $this->entityManager->flush();

        return $marketPartnerEmail;
    }

    public function delete(mixed $object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }
}
