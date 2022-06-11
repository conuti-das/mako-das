<?php

declare(strict_types=1);

namespace App\Tests\api;

use App\Entity\MarketPartner;
use App\Entity\MarketPartnerEmail;
use App\Entity\User;
use App\Tests\ApiTester;

class ApiTest
{
    protected User $apiUser;
    protected MarketPartner $apiMarketPartner;
    protected MarketPartnerEmail $apiMarketPartnerEmail;

    public function _before(ApiTester $I): void
    {
        $this->apiUser = $I->createApiUser();
        $this->apiMarketPartner = $I->createApiMarketPartner();
        $this->apiMarketPartnerEmail = $I->createApiMarketPartnerEmail($this->apiMarketPartner);
    }

    public function _after(ApiTester $I): void
    {
        $I->deleteAPIUser($this->apiUser);
        $I->deleteAPIMarketPartnerEmail($this->apiMarketPartnerEmail);
        $I->deleteAPIMarketPartner($this->apiMarketPartner);
    }
}
