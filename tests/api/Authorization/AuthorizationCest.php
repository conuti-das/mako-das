<?php

declare(strict_types=1);

namespace App\Tests\api\Authorization;

use App\Tests\ApiTester;

class AuthorizationCest
{
    public function authorizationTest(ApiTester $I): void {
        $token = $I->getJWT();
    }
}
