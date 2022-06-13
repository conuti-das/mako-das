<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\MarketPartnerEmail;
use App\Exception\MarketPartner\MarketPartnerEmptyException;
use DateTime;

class FakerMarketPartnerEmail extends Faker
{
    /**
     * @param array|null $data
     * @param bool $commit
     *
     * @return MarketPartnerEmail
     * @throws MarketPartnerEmptyException
     */
    public function create(?array $data, bool $commit = true): MarketPartnerEmail
    {
        if (!isset($data['marketPartner'])) {
            throw new MarketPartnerEmptyException("Market Partner is missing.");
        }

        $nowDate = new DateTime('now');
        $expiredDate = clone $nowDate->modify('+1 year');

        $marketPartnerEmail = new MarketPartnerEmail();
        $marketPartnerEmail->setMarketPartner($data['marketPartner']);
        $marketPartnerEmail->setCreatedAt($data['createdAt'] ?? $nowDate);
        $marketPartnerEmail->setUpdatedAt($data['updatedAt'] ?? $nowDate);
        $marketPartnerEmail->setEmail($data['email'] ?? 'debug@conuti.de');
        $marketPartnerEmail->setType($data['type'] ?? MarketPartnerEmail::TYPE_EDIFACT);
        $marketPartnerEmail->setSslCertificate(
            $data['sslCertificate'] ?? 'rjh$ZaG+xbHUauc2p5PvwNhReQ==.fdd873cc2c87b844f972a4bfa086cbb0'
        );
        $marketPartnerEmail->setSslCertificateExpiration(
            $data['sslCertificateExpiration'] ?? $expiredDate
        );
        $marketPartnerEmail->setActiveFrom($data['activeFrom'] ?? $nowDate);
        $marketPartnerEmail->setActiveUntil($data['activeUntil'] ?? $expiredDate);

        $this->entityManager->persist($marketPartnerEmail);
        $this->entityManager->flush();

        // commit the change,
        // otherwise the API will not see it
        // because it runs in another transaction
        if ($commit && $this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->commit();
        }

        return $marketPartnerEmail;
    }
}
