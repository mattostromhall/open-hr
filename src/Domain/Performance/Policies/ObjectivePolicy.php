<?php

namespace Domain\Performance\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Performance\Models\Objective;
use Illuminate\Auth\Access\HandlesAuthorization;

class ObjectivePolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function view(User $user, Objective $objective): bool
    {
        return $user->can(Ability::VIEW_OBJECTIVE->value)
            && (
                $user->person->owns($objective)
                || $user->person->isManagerFor($objective->person)
                || $user->person->isHeadOfDepartmentFor($objective->person)
            );
    }

    public function create(User $user): bool
    {
        return $user->can(Ability::CREATE_OBJECTIVE->value);
    }

    public function update(User $user, Objective $objective): bool
    {
        return $user->can(Ability::UPDATE_OBJECTIVE->value)
            && (
                $user->person->owns($objective)
                || $user->person->isManagerFor($objective->person)
                || $user->person->isHeadOfDepartmentFor($objective->person)
            );
    }

    public function delete(User $user, Objective $objective): bool
    {
        return $user->can(Ability::DELETE_OBJECTIVE->value)
            && (
                $user->person->owns($objective)
                || $user->person->isManagerFor($objective->person)
                || $user->person->isHeadOfDepartmentFor($objective->person)
            );
    }

    public function complete(User $user, Objective $objective): bool
    {
        return $user->can(Ability::COMPLETE_OBJECTIVE->value)
            && (
                $user->person->owns($objective)
                || $user->person->isManagerFor($objective->person)
                || $user->person->isHeadOfDepartmentFor($objective->person)
            );
    }
}
