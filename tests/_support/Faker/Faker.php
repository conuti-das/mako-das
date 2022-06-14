<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

abstract class Faker
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected UserPasswordHasherInterface $encoder
    ) {
    }

    abstract public function create(?array $data): object;

    public function delete(mixed $object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();

        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->commit();
        }
    }
}
