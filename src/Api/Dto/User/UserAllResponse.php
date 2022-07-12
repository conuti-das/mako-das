<?php

declare(strict_types=1);

namespace App\Api\Dto\User;

use Symfony\Component\Serializer\Annotation\Groups;

class UserAllResponse
{
    #[Groups(["users-all:read"])]
    public int $id;

    #[Groups(["users-all:read"])]
    public string $username;
}
