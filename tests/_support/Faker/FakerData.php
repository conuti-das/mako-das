<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\MarketPartner;
use App\Entity\MarketPartnerEmail;
use App\Entity\User;
use Exception;

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
        try {
            return $fakerUser->create($data, $commit);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deleteUser(User $user): void
    {
        /** @var FakerUser $fakerUser */
        $fakerUser = $this->grabService(FakerUser::class);
        try {
            $fakerUser->delete($user);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function createMarketPartner(?array $data = null, bool $commit = true): MarketPartner
    {
        /** @var FakerMarketPartner $fakerMarketPartner */
        $fakerMarketPartner = $this->grabService(FakerMarketPartner::class);

        try {
            return $fakerMarketPartner->create($data, $commit);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deleteMarketPartner(MarketPartner $marketPartner): void
    {
        /** @var FakerMarketPartner $fakerMarketPartner */
        $fakerMarketPartner = $this->grabService(FakerMarketPartner::class);

        try {
            $fakerMarketPartner->delete($marketPartner);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * @param MarketPartner $marketPartner
     * @param array|null $data
     * @param bool $commit
     *
     * @return MarketPartnerEmail
     */
    public function createMarketPartnerEmail(
        MarketPartner $marketPartner,
        ?array $data,
        bool $commit = true
    ): MarketPartnerEmail {
        /** @var FakerMarketPartnerEmail $fakerMarketPartnerEmail */
        $fakerMarketPartnerEmail = $this->grabService(FakerMarketPartnerEmail::class);

        $data['marketPartner'] = $marketPartner;

        try {
            return $fakerMarketPartnerEmail->create($data, $commit);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deleteMarketPartnerEmail(MarketPartnerEmail $marketPartnerEmail): void
    {
        /** @var FakerMarketPartnerEmail $fakerMarketPartnerEmail */
        $fakerMarketPartnerEmail = $this->grabService(FakerMarketPartnerEmail::class);

        try {
            $fakerMarketPartnerEmail->delete($marketPartnerEmail);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
