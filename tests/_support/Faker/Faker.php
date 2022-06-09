<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

abstract class Faker extends ApiTestCase
{
    abstract public function create(?array $data): object;

    abstract public function delete(): void;
}
