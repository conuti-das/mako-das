<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\User;
use DateTime;

class FakerUser extends Faker
{
    private const TEST_PASSWORD = 'test';

    public function create(?array $data): User
    {
        $entityManager = parent::getContainer()->get('doctrine.orm.entity_manager');
        $user = new User();
        $user->setUsername($data['username'] ?? 'user1@conuti.de');
        $user->setRoles($data['roles'] ?? ["ROLE_ADMIN", "ROLE_USER"]);
        $user->setPassword($data['password'] ?? self::TEST_PASSWORD);
        $user->setCreatedAt($data['createdAt'] ?? new DateTime('now'));

        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

    public function delete(): void
    {
        $entityManager = parent::getContainer()->get('doctrine.orm.entity_manager');
        $connection = $entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $tableName = $entityManager->getClassMetadata(User::class)->getTableName();
        $connection->executeUpdate($platform->getTruncateTableSQL($tableName, true));
    }
}
