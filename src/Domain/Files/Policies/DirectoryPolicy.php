<?php

namespace Domain\Files\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Models\User;

class DirectoryPolicy
{
    public function create(User $user): bool
    {
        return $user->can(Ability::CREATE_DIRECTORY->value);
    }

    public function delete(User $user): bool
    {
        return $user->can(Ability::DELETE_DIRECTORY->value);
    }
}
