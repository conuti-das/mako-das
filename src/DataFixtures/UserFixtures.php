<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use DateTime;

class UserFixtures extends Fixture
{
    private const TEST_PASSWORD = 'test';

    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     *
     * @return void
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $emails = [
            "customer@conuti.de",
            "admin@conuti.de",
        ];

        $roles = ["ROLE_ADMIN", "ROLE_USER"];

        foreach ($emails as $email) {
            $user = new User();
            $password = $this->passwordEncoder->hashPassword($user, static::TEST_PASSWORD);
            $user->setUsername($email);
            $user->setRoles($roles);
            $user->setPassword($password);
            $user->setCreatedAt(new DateTime('now'));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
