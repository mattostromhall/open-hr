<?php

namespace Domain\Performance\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Performance\Models\OneToOne;
use Illuminate\Auth\Access\HandlesAuthorization;

class OneToOnePolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function view(User $user, OneToOne $oneToOne): bool
    {
        return $user->can(Ability::VIEW_ONE_TO_ONE->value)
            && (
                $user->person->owns($oneToOne)
                || $user->person->isManagerFor($oneToOne->person)
                || $user->person->isHeadOfDepartmentFor($oneToOne->person)
            );
    }

    public function create(User $user): bool
    {
        return $user->can(Ability::CREATE_ONE_TO_ONE->value);
    }

    public function update(User $user, OneToOne $oneToOne): bool
    {
        return $user->can(Ability::UPDATE_ONE_TO_ONE->value)
            && (
                $user->person->owns($oneToOne)
                || $user->person->isManagerFor($oneToOne->person)
                || $user->person->isHeadOfDepartmentFor($oneToOne->person)
            );
    }

    public function delete(User $user, OneToOne $oneToOne): bool
    {
        return $user->can(Ability::DELETE_ONE_TO_ONE->value)
            && (
                $user->person->owns($oneToOne)
                || $user->person->isManagerFor($oneToOne->person)
                || $user->person->isHeadOfDepartmentFor($oneToOne->person)
            );
    }

    public function complete(User $user, OneToOne $oneToOne): bool
    {
        return $user->can(Ability::COMPLETE_ONE_TO_ONE->value)
            && (
                $user->person->owns($oneToOne)
                || $user->person->isManagerFor($oneToOne->person)
                || $user->person->isHeadOfDepartmentFor($oneToOne->person)
            );
    }

    public function schedule(User $user): bool
    {
        return $user->can(Ability::SCHEDULE_ONE_TO_ONE->value);
    }
}
