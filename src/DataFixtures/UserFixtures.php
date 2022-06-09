<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use DateTime;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private const TEST_PASSWORD = 'test';

    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public static function getGroups(): array
    {
        return ['demo'];
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

        $i = 1;
        foreach ($emails as $email) {
            $user = new User();
            $user->setId($i);
            $password = $this->passwordEncoder->hashPassword($user, static::TEST_PASSWORD);
            $user->setUsername($email);
            $user->setRoles($roles);
            $user->setPassword($password);
            $user->setCreatedAt(new DateTime('now'));

            $metadata = $manager->getClassMetaData(User::class);
            $metadata->setIdGenerator(new AssignedGenerator());
            $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_NONE);
            $manager->persist($user);
            $manager->flush();

            $this->addReference('user-' . $i, $user);

            $i++;
        }

        // add API User
        $user = new User();
        $user->setId($i);
        $password = $this->passwordEncoder->hashPassword($user, static::TEST_PASSWORD);
        $user->setUsername("api@conuti.de");
        $user->setRoles(["ROLE_USER_API"]);
        $user->setPassword($password);
        $user->setCreatedAt(new DateTime('now'));

        $metadata = $manager->getClassMetaData(User::class);
        $metadata->setIdGenerator(new AssignedGenerator());
        $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_NONE);
        $manager->persist($user);
        $manager->flush();

        $this->addReference('user-api', $user);
    }
}
