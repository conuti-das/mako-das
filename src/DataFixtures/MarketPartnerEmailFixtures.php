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

        $marketPartnerEmail = new MarketPartnerEmail();
        $marketPartnerEmail->setMarketPartnerId(1);
        $marketPartnerEmail->setCreatedAt($nowDate);
        $marketPartnerEmail->setEmail('test123@gmail.com');
        $marketPartnerEmail->setType(['edifact', 'reminder']);
        $marketPartnerEmail->setSslCertificate('long text');
        $marketPartnerEmail->setSslCertificateExpiration($nowDate);
        $marketPartnerEmail->setActiveFrom($nowDate);
        $marketPartnerEmail->setActiveUntil($nowDate);
        $manager->persist($marketPartnerEmail);
        $manager->flush();
    }
}
