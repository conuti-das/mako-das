<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\MarketPartnerEmail;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class MarketPartnerEmailFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @return void
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $nowDate = new DateTime('now');
        $expiredDate = clone $nowDate->modify('+1 year');

        $marketPartnerEmail = new MarketPartnerEmail();
        $marketPartnerEmail->setMarketPartnerId(1);
        $marketPartnerEmail->setCreatedAt($nowDate);
        $marketPartnerEmail->setEmail('debug@conuti.de');
        $marketPartnerEmail->setType(MarketPartnerEmail::TYPE_EDIFACT);
        $marketPartnerEmail->setSslCertificate('rjh$ZaG+xbHUauc2p5PvwNhReQ==.fdd873cc2c87b844f972a4bfa086cbb0');
        $marketPartnerEmail->setSslCertificateExpiration($expiredDate);
        $marketPartnerEmail->setActiveFrom($nowDate);
        $marketPartnerEmail->setActiveUntil($expiredDate);
        $manager->persist($marketPartnerEmail);
        $manager->flush();
    }
}
