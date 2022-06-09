<?php

declare(strict_types=1);

namespace App\Tests\api\Authorization;

use App\Tests\ApiTester;
use App\Tests\Faker\FakerUser;

class AuthorizationCest
{
    public function authorizationFailedTest(ApiTester $I): void
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/api/market-partners');
        $I->seeResponseCodeIs(401);
        $I->assertJson(' {"code":401,"message":"JWT Token not found"}');
    }

    public function authorizationSuccessTest(ApiTester $I): void
    {
        $fakerUser = new FakerUser();
        $fakerUser->create([]);
        $I->amBearerAuthenticated($I->getJWT());
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/api/market-partners');
        $I->seeResponseCodeIs(200);
        $fakerUser->delete();
    }
}
