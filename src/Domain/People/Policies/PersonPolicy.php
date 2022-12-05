<?php

namespace Domain\People\Policies;

use Domain\Absences\Models\Holiday;
use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\People\Models\Person;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function viewAll(User $user): bool
    {
        return $user->can(Ability::VIEW_PERSON->value)
            && $user->can(Ability::VIEW_USER->value);
    }

    public function view(User $user, Person $person): bool
    {
        return $user->can(Ability::VIEW_PERSON->value)
            && $user->can(Ability::VIEW_USER->value)
            && (
                $user->person->owns($person, 'id')
                || $user->person->isManagerFor($person)
                || $user->person->isHeadOfDepartmentFor($person)
            );
    }

    public function create(User $user): bool
    {
        return $user->can(Ability::CREATE_PERSON->value)
            && $user->can(Ability::CREATE_USER->value);
    }

    public function update(User $user, Person $person): bool
    {
        return $user->can(Ability::UPDATE_PERSON->value)
            && $user->can(Ability::UPDATE_USER->value)
            && (
                $user->person->owns($person, 'id')
                || $user->person->isManagerFor($person)
                || $user->person->isHeadOfDepartmentFor($person)
            );
    }

    public function delete(User $user, Person $person): bool
    {
        return $user->can(Ability::DELETE_PERSON->value)
                && $user->can(Ability::DELETE_USER->value)
            && (
                $user->person->owns($person, 'id')
                || $user->person->isManagerFor($person)
                || $user->person->isHeadOfDepartmentFor($person)
            );
    }

    public function manageDirectReports(User $user, Person $person): bool
    {
        return $user->can(Ability::MANAGE_DIRECT_REPORTS->value)
            && (
                $user->person->owns($person, 'id')
                || $user->person->isManagerFor($person)
                || $user->person->isHeadOfDepartmentFor($person)
            );
    }

    public function managementDashboard(User $user): bool
    {
        return $user->isA(Role::MANAGER->value)
            || $user->isA(Role::HEAD_OF_DEPARTMENT->value);
    }
}
