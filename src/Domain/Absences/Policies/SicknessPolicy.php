<?php

namespace Domain\Absences\Policies;

use Domain\Absences\Models\Sickness;
use Domain\Auth\Enums\Ability;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SicknessPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->can(Ability::CREATE_SICKNESS->value);
    }

    public function view(User $user, Sickness $sickness): bool
    {
        return $user->can(Ability::VIEW_SICKNESS->value)
            && (
                $user->person->owns($sickness)
                || $user->person->isManagerFor($sickness->person)
                || $user->person->isHeadOfDepartmentFor($sickness->person)
            );
    }

    public function update(User $user, Sickness $sickness): bool
    {
        return $user->can(Ability::UPDATE_SICKNESS->value)
            && (
                $user->person->owns($sickness)
                || $user->person->isManagerFor($sickness->person)
                || $user->person->isHeadOfDepartmentFor($sickness->person)
            );
    }

    public function delete(User $user, Sickness $sickness): bool
    {
        return $user->can(Ability::DELETE_SICKNESS->value)
            && (
                $user->person->isManagerFor($sickness->person)
                || $user->person->isHeadOfDepartmentFor($sickness->person)
            );
    }
}
