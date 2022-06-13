<?php

declare(strict_types=1);

namespace App\Tests\api\MarketPartnerEmail;

use App\Entity\MarketPartner;
use App\Entity\MarketPartnerEmail;
use App\Tests\api\ApiTest;
use App\Tests\ApiTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class MarketPartnerEmailCest extends ApiTest
{
    protected MarketPartnerEmail $apiMarketPartnerEmail;

    protected MarketPartner $apiMarketPartner;

    public function _before(ApiTester $I): void
    {
        parent::_before($I);
        $this->apiMarketPartner = $I->createMarketPartner();
        $this->apiMarketPartnerEmail = $I->createMarketPartnerEmail($this->apiMarketPartner);
    }

    /**
     * @param ApiTester $I
     * @param Example $example
     *
     * @return void
     * @example {"email": "debug@conuti.de", "type": "edifact", "sslCertificate": "rjh$ZaG+xbHUauc2p5PvwNhReQ==.fdd873cc2c87b844f972a4bfa086cbb0", "sslCertificateExpiration": "2023-05-23T13:17:20+00:00", "activeFrom": "2023-05-23T13:17:20+00:00", "activeUntil": "2023-05-23T13:17:20+00:00"}
     */
    public function marketPartnerEmailTest(ApiTester $I, Example $example): void
    {
        $I->amBearerAuthenticated($I->getJWT());
        $I->haveHttpHeader('accept', 'application/ld+json');
        $I->sendGet('/api/market-partners-email');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            ["marketPartner" => ["partnerId" => "9900080000007"]],
            ['email' => $example['email']],
            ['type' => $example['type']],
            ['sslCertificate' => $example['sslCertificate']],
            ['sslCertificateExpiration' => $example['sslCertificateExpiration']],
            ['activeFrom' => $example['activeFrom']],
            ['activeUntil' => $example['activeUntil']]
        );
        $I->canSeeResponseCodeIsSuccessful();
    }

    /**
     * @param ApiTester $I
     * @param Example $example
     *
     * @return void
     * @example {"email": "debug@conuti.de", "type": "edifact", "sslCertificate": "rjh$ZaG+xbHUauc2p5PvwNhReQ==.fdd873cc2c87b844f972a4bfa086cbb0", "sslCertificateExpiration": "2023-05-23T13:17:20+00:00", "activeFrom": "2023-05-23T13:17:20+00:00", "activeUntil": "2023-05-23T13:17:20+00:00"}
     */
    public function marketPartnerEmailSingleTest(ApiTester $I, Example $example): void
    {
        $I->amBearerAuthenticated($I->getJWT());
        $I->haveHttpHeader('accept', 'application/ld+json');
        $I->sendGet('/api/market-partners-email/' . $this->apiMarketPartnerEmail->getId());
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            ["marketPartner" => ["partnerId" => "9900080000007"]],
            ['email' => $example['email']],
            ['type' => $example['type']],
            ['sslCertificate' => $example['sslCertificate']],
            ['sslCertificateExpiration' => $example['sslCertificateExpiration']],
            ['activeFrom' => $example['activeFrom']],
            ['activeUntil' => $example['activeUntil']]
        );
        $I->canSeeResponseCodeIsSuccessful();
    }

    public function _after(ApiTester $I): void
    {
        parent::_after($I);
        $I->deleteMarketPartnerEmail($this->apiMarketPartnerEmail);
        $I->deleteMarketPartner($this->apiMarketPartner);
    }
}
