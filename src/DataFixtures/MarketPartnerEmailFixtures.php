<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\MarketPartnerEmail;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ObjectManager;
use Exception;

class MarketPartnerEmailFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function getDependencies(): array
    {
        return [
            MarketPartnerFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return ['demo'];
    }

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
        $marketPartnerEmail->setId(1);
        $marketPartnerEmail->setMarketPartner($this->getReference('market-partner-1'));
        $marketPartnerEmail->setCreatedAt($nowDate);
        $marketPartnerEmail->setUpdatedAt($nowDate);
        $marketPartnerEmail->setEmail('debug@conuti.de');
        $marketPartnerEmail->setType(MarketPartnerEmail::TYPE_EDIFACT);
        $marketPartnerEmail->setSslCertificate('rjh$ZaG+xbHUauc2p5PvwNhReQ==.fdd873cc2c87b844f972a4bfa086cbb0');
        $marketPartnerEmail->setSslCertificateExpiration($expiredDate);
        $marketPartnerEmail->setActiveFrom($nowDate);
        $marketPartnerEmail->setActiveUntil($expiredDate);

        $metadata = $manager->getClassMetaData(MarketPartnerEmail::class);
        $metadata->setIdGenerator(new AssignedGenerator());
        $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_NONE);
        $manager->persist($marketPartnerEmail);
        $manager->flush();

        $this->addReference('market-partner-email-1', $marketPartnerEmail);
    }
}
