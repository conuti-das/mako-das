<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\MarketPartner;
use DateTime;

class FakerMarketPartner extends Faker
{
    public function create(?array $data): MarketPartner
    {
        $marketPartner = new MarketPartner();
        $marketPartner->setId($data['id'] ?? 1);
        $marketPartner->setActive($data['active'] ?? 1);
        $marketPartner->setDeleted($data['deletedAt'] ?? 0);
        $marketPartner->setCreatedAt($data['createdAt'] ?? new DateTime("2022-05-23T13:17:20+00:00"));
        $marketPartner->setUpdatedAt($data['updatedAt'] ?? new DateTime("2022-06-23T00:00:00+00:00"));
        $marketPartner->setType($data['type'] ?? MarketPartner::TYPE_NET);
        $marketPartner->setEnergy($data['energy'] ?? MarketPartner::ENERGY_ELECTRICITY);
        $marketPartner->setPartnerId($data['partnerId'] ?? '9900080000007');
        $marketPartner->setPartnerIdType($data['partnerIdType'] ?? MarketPartner::NUMBER_BDEW);
        $marketPartner->setOrganization($data['organization'] ?? 'Stromnetz Berlin GmbH');
        $marketPartner->setZip($data['zip'] ?? '12435');
        $marketPartner->setCity($data['city'] ?? "Berlin");
        $marketPartner->setStreet($data['street'] ?? "Eichenstraße");
        $marketPartner->setHouseNumber($data['houseNumber'] ?? "3a");
        $marketPartner->setIban($data['iban'] ?? 'DE85120300000001122445');
        $marketPartner->setBic($data['bic'] ?? 'BYLADEM1001');
        $marketPartner->setBank($data['bank'] ?? 'DEUTSCHE KREDIT BANK A.G. BERLIN');
        $marketPartner->setAccountHolder($data['accountHolder'] ?? 'Stromnetz Berlin GmbH');
        $marketPartner->setPhone($data['phone'] ?? '+49 30 0000 000');
        $marketPartner->setRegisterCourt($data['registerCourt'] ?? 'Charlottenburg (Berlin) HRB 179968 B');
        $marketPartner->setRegisterNumber($data['registerNumber'] ?? 'DE308492655');
        $marketPartner->setSign($data['sign'] ?? 0);
        $marketPartner->setCompress($data['compress'] ?? 0);
        $marketPartner->setEncrypt($data['encrypt'] ?? 0);
        $marketPartner->setReminderEmailAddress($data['reminderEmailAddress'] ?? 'debug@conuti.de');
        $marketPartner->setUsingTumCatalog($data['usingTumCatalog'] ?? 0);
        $this->entityManager->persist($marketPartner);
        $this->entityManager->flush();

        return $marketPartner;
    }

    public function delete(mixed $object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }
}
