<?php

namespace Domain\Performance\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Performance\Models\Training;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrainingPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function view(User $user, Training $training): bool
    {
        return $user->can(Ability::VIEW_TRAINING->value)
            && (
                $user->person->owns($training)
                || $user->person->isManagerFor($training->person)
                || $user->person->isHeadOfDepartmentFor($training->person)
            );
    }

    public function create(User $user): bool
    {
        return $user->can(Ability::CREATE_TRAINING->value);
    }

    public function update(User $user, Training $training): bool
    {
        return $user->can(Ability::UPDATE_TRAINING->value)
            && (
                $user->person->owns($training)
                || $user->person->isManagerFor($training->person)
                || $user->person->isHeadOfDepartmentFor($training->person)
            );
    }

    public function delete(User $user, Training $training): bool
    {
        return $user->can(Ability::DELETE_TRAINING->value)
            && (
                $user->person->owns($training)
                || $user->person->isManagerFor($training->person)
                || $user->person->isHeadOfDepartmentFor($training->person)
            );
    }

    public function review(User $user, Training $training): bool
    {
        return $user->can(Ability::REVIEW_TRAINING->value)
            && (
                $user->person->isManagerFor($training->person)
                || $user->person->isHeadOfDepartmentFor($training->person)
            );
    }

    public function complete(User $user, Training $training): bool
    {
        return $user->can(Ability::COMPLETE_TRAINING->value)
            && (
                $user->person->owns($training)
                || $user->person->isManagerFor($training->person)
                || $user->person->isHeadOfDepartmentFor($training->person)
            );
    }

    public function manage(User $user): bool
    {
        return $user->isA(Role::MANAGER->value);
    }
}
