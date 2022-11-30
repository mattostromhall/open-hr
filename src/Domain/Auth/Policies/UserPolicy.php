<?php

namespace Domain\Auth\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function update(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->can(Ability::UPDATE_USER->value)
            && (
                $authenticatedUser->id === $user->id
                || $authenticatedUser->person->isManagerFor($user->person)
                || $authenticatedUser->person->isHeadOfDepartmentFor($user->person)
            );
    }

    public function updatePassword(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->can(Ability::UPDATE_USER->value)
            && $authenticatedUser->id === $user->id;
    }
}
