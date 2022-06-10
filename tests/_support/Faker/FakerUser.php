<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\User;
use DateTime;

class FakerUser extends Faker
{
    private const TEST_PASSWORD = 'test';

    public function create(?array $data, bool $commit = true): User
    {
        $user = new User();
        $user->setUsername($data['username'] ?? 'user1@conuti.de');
        $user->setRoles($data['roles'] ?? ["ROLE_ADMIN", "ROLE_USER"]);
        $password = $this->encoder->hashPassword($user, $data['password'] ?? static::TEST_PASSWORD);
        $user->setPassword($password);
        $user->setCreatedAt($data['createdAt'] ?? new DateTime('now'));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // commit the change,
        // otherwise the API will not see it
        // because it runs in another transaction
        if($commit) {
            $this->entityManager->commit();
        }

        return $user;
    }

    public function delete(mixed $object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }
}
