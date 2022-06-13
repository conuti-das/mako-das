<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\MarketPartner;
use App\Entity\MarketPartnerEmail;
use App\Entity\User;
use App\Tests\Faker\FakerMarketPartner;
use App\Tests\Faker\FakerMarketPartnerEmail;
use App\Tests\Faker\FakerUser;
use Codeception\Actor;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
 */
class ApiTester extends Actor
{
    use _generated\ApiTesterActions;

    public function getJWT(): string
    {
        $this->haveHttpHeader('accept', 'application/json');
        $this->haveHttpHeader('Content-Type', 'application/json');
        $this->sendPost(
            '/api/authorization',
            [
                'username' => $_ENV['API_TEST_USERNAME'],
                'password' => $_ENV['API_TEST_PASSWORD'],
            ]
        );
        $this->seeResponseCodeIs(200);

        $token = $this->grabDataFromResponseByJsonPath('token');
        $this->assertNotEmpty($token);

        return $token[0];
    }

    public function createApiUser(): User
    {
        /** @var FakerUser $fakerUser */
        $fakerUser = $this->grabService(FakerUser::class);

        return $fakerUser->create([
            'username' => $_ENV['API_TEST_USERNAME'],
            'password' => $_ENV['API_TEST_PASSWORD'],
            'roles' => ["ROLE_USER_API"]
        ]);
    }

    public function createApiMarketPartner(array $data = []): MarketPartner
    {
        /** @var FakerMarketPartner $fakerMarketPartner */
        $fakerMarketPartner = $this->grabService(FakerMarketPartner::class);

        return $fakerMarketPartner->create($data);
    }

    public function createApiMarketPartnerEmail(MarketPartner $apiMarketPartner, array $data = []): MarketPartnerEmail
    {
        /** @var FakerMarketPartnerEmail $fakerMarketPartnerEmail */
        $fakerMarketPartnerEmail = $this->grabService(FakerMarketPartnerEmail::class);

        $data['marketPartner'] = $apiMarketPartner;

        return $fakerMarketPartnerEmail->create($data);
    }

    public function deleteAPIUser(User $user): void
    {
        /** @var FakerUser $fakerUser */
        $fakerUser = $this->grabService(FakerUser::class);
        $fakerUser->delete($user);
    }

    public function deleteAPIMarketPartner(MarketPartner $marketPartner): void
    {
        /** @var FakerMarketPartner $fakerMarketPartner */
        $fakerMarketPartner = $this->grabService(FakerMarketPartner::class);
        $fakerMarketPartner->delete($marketPartner);
    }

    public function deleteAPIMarketPartnerEmail(MarketPartnerEmail $marketPartnerEmail): void
    {
        /** @var FakerMarketPartnerEmail $fakerMarketPartnerEmail */
        $fakerMarketPartnerEmail = $this->grabService(FakerMarketPartnerEmail::class);
        $fakerMarketPartnerEmail->delete($marketPartnerEmail);
    }
}
