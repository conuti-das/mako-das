<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\MarketPartner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ObjectManager;
use DateTime;
use Exception;

class MarketPartnerFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
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
        $marketPartner = new MarketPartner();
        $marketPartner->setId(1);
        $marketPartner->setActive(1);
        $marketPartner->setDeleted(0);
        $marketPartner->setCreatedAt(new DateTime('now'));
        $marketPartner->setType(MarketPartner::TYPE_NET);
        $marketPartner->setEnergy(MarketPartner::ENERGY_ELECTRICITY);
        $marketPartner->setPartnerId('9900080000007');
        $marketPartner->setPartnerIdType(MarketPartner::NUMBER_BDEW);
        $marketPartner->setOrganization('Stromnetz Berlin GmbH');
        $marketPartner->setZip('12435');
        $marketPartner->setCity("Berlin");
        $marketPartner->setStreet("Eichenstraße");
        $marketPartner->setHouseNumber("3a");
        $marketPartner->setIban('DE85120300000001122445');
        $marketPartner->setBic('BYLADEM1001');
        $marketPartner->setBank('DEUTSCHE KREDIT BANK A.G. BERLIN');
        $marketPartner->setAccountHolder('Stromnetz Berlin GmbH');
        $marketPartner->setPhone('+49 30 0000 000');
        $marketPartner->setRegisterCourt('Charlottenburg (Berlin) HRB 179968 B');
        $marketPartner->setRegisterNumber('DE308492655');
        $marketPartner->setSign(0);
        $marketPartner->setCompress(0);
        $marketPartner->setEncrypt(0);
        $marketPartner->setReminderEmailAddress('debug@conuti.de');
        $marketPartner->setUsingTumCatalog(0);

        $metadata = $manager->getClassMetaData(MarketPartner::class);
        $metadata->setIdGenerator(new AssignedGenerator());
        $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_NONE);
        $manager->persist($marketPartner);
        $manager->flush();

        $this->addReference('market-partner-1', $marketPartner);
    }
}
