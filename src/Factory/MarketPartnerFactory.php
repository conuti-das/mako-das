<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\MarketPartner;
use DateTime;

class MarketPartnerFactory
{
    public function createFromArray(array $marketPartnerData): MarketPartner
    {
        $marketPartner = new MarketPartner();
        $marketPartner->setType($marketPartnerData["type"]);
        $marketPartner->setPartnerId($marketPartnerData["partnerId"]);
        $marketPartner->setOrganization($marketPartnerData["organization"]);
        $marketPartner->setEnergy($marketPartnerData["energy"]);
        $marketPartner->setActive((int)$marketPartnerData["active"]);
        $marketPartner->setZip($marketPartnerData["zip"]);
        $marketPartner->setCity($marketPartnerData["city"]);
        $marketPartner->setStreet($marketPartnerData["street"]);
        $marketPartner->setHouseNumber($marketPartnerData["houseNumber"]);
        $marketPartner->setIban($marketPartnerData["iban"]);
        $marketPartner->setBic($marketPartnerData["bic"]);
        $marketPartner->setBank($marketPartnerData["bank"]);
        $marketPartner->setAccountHolder($marketPartnerData["accountHolder"]);
        $marketPartner->setDeleted((int)$marketPartnerData["deleted"]);
        $marketPartner->setReminderEmailAddress($marketPartnerData["reminderEmailAddress"]);

        $marketPartner->setCreatedAt(new DateTime('now'));
        $marketPartner->setSign(0);
        $marketPartner->setCompress(0);
        $marketPartner->setEncrypt(0);
        $marketPartner->setUsingTumCatalog(0);

        return $marketPartner;
    }
}
