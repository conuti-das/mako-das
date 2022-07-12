<?php

declare(strict_types=1);

namespace App\Api\DataTransformer\User;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Api\Dto\User\UserAllResponse;
use App\Entity\User;
use JetBrains\PhpStorm\Pure;

class UserAllOutputDataTransformer implements DataTransformerInterface
{
    #[Pure] public function transform($object, string $to, array $context = []): UserAllResponse
    {
        /** @var User $object */
        $user = new UserAllResponse();
        $user->id = $object->getId();
        $user->username = $object->getUserIdentifier();

        return $user;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $to === UserAllResponse::class && $data instanceof User;
    }
}
