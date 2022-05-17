<?php

namespace App\DataFixtures;

use App\Entity\MarketPartnerEmail;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MarketPartnerEmailFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @return void
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $marketPartnerEmail = new MarketPartnerEmail();
        $marketPartnerEmail->setMarketPartnerId(1);
        $marketPartnerEmail->setCreatedAt(new DateTime(date("Y-m-d h:i:s")));
        $marketPartnerEmail->setEmail('test123@gmail.com');
        $marketPartnerEmail->setType(['edifact','reminder']);
        $marketPartnerEmail->setSslCertificate('long text');
        $marketPartnerEmail->setSslCertificateExpiration(new DateTime(date("Y-m-d h:i:s")));
        $marketPartnerEmail->setActiveFrom(new DateTime(date("Y-m-d h:i:s")));
        $marketPartnerEmail->setActiveUntil(new DateTime(date("Y-m-d h:i:s")));
        $manager->persist($marketPartnerEmail);
        $manager->flush();
    }
}
