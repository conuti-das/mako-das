<?php

declare(strict_types=1);

namespace App\Tests\api;

use App\Entity\User;
use App\Repository\UserRepository;
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
        $apiUserId = $this->apiUser->getId();
        $I->deleteApiUser($this->apiUser);

        $userRepository = $I->grabService(UserRepository::class);
        $apiUser = $userRepository->find($apiUserId);
        if ($apiUser instanceof User) {
            die("Deletion of the user failed!");
        }
    }
}
