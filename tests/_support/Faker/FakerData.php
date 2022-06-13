<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\MarketPartner;
use App\Entity\MarketPartnerEmail;
use App\Entity\User;
use App\Exception\MarketPartner\MarketPartnerEmptyException;

trait FakerData
{
    public function createApiUser(): User
    {
        return $this->createUser([
            'username' => $_ENV['API_TEST_USERNAME'],
            'password' => $_ENV['API_TEST_PASSWORD'],
            'roles' => ["ROLE_USER_API"]
        ]);
    }

    public function deleteApiUser(User $user): void
    {
        $this->deleteUser($user);
    }

    public function createUser(?array $data, bool $commit = true): User
    {
        /** @var FakerUser $fakerUser */
        $fakerUser = $this->grabService(FakerUser::class);

        return $fakerUser->create($data, $commit);
    }

    public function deleteUser(User $user): void
    {
        /** @var FakerUser $fakerUser */
        $fakerUser = $this->grabService(FakerUser::class);
        $fakerUser->delete($user);
    }

    public function createMarketPartner(?array $data, bool $commit = true): MarketPartner
    {
        /** @var FakerMarketPartner $fakerMarketPartner */
        $fakerMarketPartner = $this->grabService(FakerMarketPartner::class);

        return $fakerMarketPartner->create($data, $commit);
    }

    public function deleteMarketPartner(MarketPartner $marketPartner): void
    {
        /** @var FakerMarketPartner $fakerMarketPartner */
        $fakerMarketPartner = $this->grabService(FakerMarketPartner::class);
        $fakerMarketPartner->delete($marketPartner);
    }

    /**
     * @param MarketPartner $marketPartner
     * @param array|null $data
     * @param bool $commit
     *
     * @return MarketPartnerEmail
     * @throws MarketPartnerEmptyException
     */
    public function createMarketPartnerEmail(
        MarketPartner $marketPartner,
        ?array $data,
        bool $commit = true
    ): MarketPartnerEmail {
        /** @var FakerMarketPartnerEmail $fakerMarketPartnerEmail */
        $fakerMarketPartnerEmail = $this->grabService(FakerMarketPartnerEmail::class);

        $data['marketPartner'] = $marketPartner;

        return $fakerMarketPartnerEmail->create($data, $commit);
    }

    public function deleteMarketPartnerEmail(MarketPartnerEmail $marketPartnerEmail): void
    {
        /** @var FakerMarketPartnerEmail $fakerMarketPartnerEmail */
        $fakerMarketPartnerEmail = $this->grabService(FakerMarketPartnerEmail::class);
        $fakerMarketPartnerEmail->delete($marketPartnerEmail);
    }
}
