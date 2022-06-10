<?php

declare(strict_types=1);

namespace App\Tests\api;

use App\Entity\User;
use App\Tests\ApiTester;

class ApiTest
{
    protected User $apiUser;

    public function _before(ApiTester $I): void
    {
        $this->apiUser = $I->createApiUser();
    }

    public function _after(ApiTester $I): void
    {
        $I->deleteAPIUser($this->apiUser);
    }
}
