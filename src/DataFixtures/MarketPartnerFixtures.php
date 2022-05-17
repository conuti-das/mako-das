<?php

namespace App\DataFixtures;

use App\Entity\MarketPartner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class MarketPartnerFixtures extends Fixture
{

    /**
     * @param ObjectManager $manager
     *
     * @return void
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $marketPartner = new MarketPartner();
        $marketPartner->setActive(1);
        $marketPartner->setCreatedAt(new DateTime(date("Y-m-d h:i:s")));
        $marketPartner->setType(['net', 'provider', 'msb', 'tso']);
        $marketPartner->setEnergy(['electricity', 'gas', 'water_sewage']);
        $marketPartner->setPartnerId(1);
        $marketPartner->setPartnerIdType(['bdew', 'iln', 'dvgw']);
        $marketPartner->setPartnerIdGmsb(2);
        $marketPartner->setOrganization('testOrganization');
        $marketPartner->setZip(2);
        $marketPartner->setCity("Yerevan");
        $marketPartner->setStreet("Aram Xachatryan");
        $marketPartner->setHouseNumber("Aram Xachatryan 33");
        $marketPartner->setAccountId(3);
        $marketPartner->setIban('testIban');
        $marketPartner->setBic('testBic');
        $marketPartner->setBank('bank');
        $marketPartner->setAccountHolder('Account Holder');
        $marketPartner->setPhone('+374 77 001-001');
        $marketPartner->setRegisterCourt('test Court');
        $marketPartner->setRegisterNumber('test Register Number');
        $marketPartner->setSign(2);
        $marketPartner->setCompress(4);
        $marketPartner->setEncrypt(6);
        $marketPartner->setReminderEmailAddress('test123@gmail.com');
        $marketPartner->setUsingTumCatalog(3);
        $marketPartner->setAboDARef('test aboDARef');
        $marketPartner->setAboBgmNr('test AboBgmNr');
        $marketPartner->setAboSendDate(new DateTime(date("Y-m-d h:i:s")));
        $marketPartner->setAboIsSent(2);
        $marketPartner->setLockPayoutsRemadv(5);
        $marketPartner->setSyncNotWithMaster(2);
        $manager->persist($marketPartner);
        $manager->flush();
    }
}
