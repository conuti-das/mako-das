<?php

declare(strict_types=1);

namespace App\Tests\api\MarketPartner;

use App\Tests\api\ApiTest;
use App\Tests\ApiTester;
use Codeception\Example;
use Codeception\Util\HttpCode;
use App\Entity\MarketPartner;

class MarketPartnerCest extends ApiTest
{
    protected MarketPartner $apiMarketPartner;

    public function _before(ApiTester $I): void
    {
        parent::_before($I);
        $this->apiMarketPartner = $I->createMarketPartner();
    }

    /**
     * @param ApiTester $I
     * @param Example $example
     *
     * @return void
     * @example {"partnerId": "9900080000007", "isActive": "1" }
     */
    public function marketPartnerTest(ApiTester $I, Example $example): void
    {
        $I->amBearerAuthenticated($I->getJWT());
        $I->haveHttpHeader('accept', 'application/ld+json');
        $I->sendGet('/api/market-partners');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['partnerId' => $example['partnerId']], ['isActive' => $example['isActive']]);
        $I->canSeeResponseCodeIsSuccessful();
    }

    /**
     * @param ApiTester $I
     * @param Example $example
     *
     * @return void
     * @example {"id": "1","active": "1", "deleted": "0", "createdAt": "2022-05-23T13:17:20+00:00","updatedAt": "2022-06-23T00:00:00+00:00", "type": "net", "energy": "electricity", "partnerId": "9900080000007", "partnerIdType": "bdew", "partnerIdGmsb": "null", "organization": "Stromnetz Berlin GmbH", "zip": "12435", "city": "Berlin", "street": "Eichenstraße", "houseNumber": "3a", "iban": "DE85120300000001122445", "bic": "BYLADEM1001", "bank": "DEUTSCHE KREDIT BANK A.G. BERLIN", "accountHolder": "Stromnetz Berlin GmbH", "phone": "+49 30 0000 000", "registerCourt": "Charlottenburg (Berlin) HRB 179968 B", "registerNumber": "DE308492655", "sign": "0", "compress": "0", "encrypt": "0", "reminderEmailAddress": "debug@conuti.de", "usingTumCatalog": "0", "marketPartnerEmails": "string" }
     */
    public function marketPartnerSingleTest(ApiTester $I, Example $example): void
    {
        $I->amBearerAuthenticated($I->getJWT());
        $I->haveHttpHeader('accept', 'application/ld+json');
        $I->sendGet('/api/market-partners/' . $this->apiMarketPartner->getId());
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            ['active' => $example['active']],
            ['deleted' => $example['deleted']],
            ['createdAt' => $example['createdAt']],
            ['updatedAt' => $example['updatedAt']],
            ['type' => $example['type']],
            ['energy' => $example['energy']],
            ['partnerId' => $example['partnerId']],
            ['partnerIdType' => $example['partnerIdType']],
            ['partnerIdGmsb' => $example['partnerIdGmsb']],
            ['organization' => $example['organization']],
            ['zip' => $example['zip']],
            ['city' => $example['city']],
            ['street' => $example['street']],
            ['houseNumber' => $example['houseNumber']],
            ['iban' => $example['iban']],
            ['bic' => $example['bic']],
            ['bank' => $example['bank']],
            ['accountHolder' => $example['accountHolder']],
            ['phone' => $example['phone']],
            ['registerCourt' => $example['registerCourt']],
            ['registerNumber' => $example['registerNumber']],
            ['sign' => $example['sign']],
            ['compress' => $example['compress']],
            ['encrypt' => $example['encrypt']],
            ['reminderEmailAddress' => $example['reminderEmailAddress']],
            ['usingTumCatalog' => $example['usingTumCatalog']]
        );
        $I->canSeeResponseCodeIsSuccessful();
    }

    public function _after(ApiTester $I): void
    {
        parent::_after($I);
        $I->deleteMarketPartner($this->apiMarketPartner);
    }
}
