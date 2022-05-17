<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use DateTime;

class UserFixtures extends Fixture
{
    /**
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct
    (
        UserPasswordEncoderInterface $encoder
    )
    {
        $this->passwordEncoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     *
     * @return void
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $test_password = 'test';

        $emails = [
            "customer@conuti.de",
            "admin@conuti.de",
        ];

        $roles = ["ROLE_ADMIN", "ROLE_USER"];

        foreach ($emails as $email) {
           $user = new User();
           $password = $this->passwordEncoder->encodePassword($user, $test_password);
           $user->setUsername($email);
           $user->setRoles($roles);
           $user->setPassword($password);
           $user->setCreatedAt(new DateTime(date("Y-m-d h:i:s")));
           $manager->persist($user);
        }
        $manager->flush();
    }
}
