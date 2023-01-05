<?php

namespace Domain\Absences\Policies;

use Domain\Absences\Models\Holiday;
use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HolidayPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function create(User $user): bool
    {
        return $user->can(Ability::CREATE_HOLIDAY->value);
    }

    public function view(User $user, Holiday $holiday): bool
    {
        return $user->can(Ability::VIEW_HOLIDAY->value)
            && (
                $user->person->owns($holiday)
                || $user->person->isManagerFor($holiday->person)
                || $user->person->isHeadOfDepartmentFor($holiday->person)
            );
    }

    public function update(User $user, Holiday $holiday): bool
    {
        return $user->can(Ability::UPDATE_HOLIDAY->value)
            && $user->person->owns($holiday);
    }

    public function delete(User $user, Holiday $holiday): bool
    {
        return $user->can(Ability::DELETE_HOLIDAY->value)
            && $user->person->owns($holiday);
    }

    public function review(User $user, Holiday $holiday): bool
    {
        return $user->can(Ability::REVIEW_HOLIDAY->value)
            && (
                $user->person->isManagerFor($holiday->person)
                || $user->person->isHeadOfDepartmentFor($holiday->person)
            );
    }

    public function viewCalendar(User $user): bool
    {
        return $user->can(Ability::VIEW_HOLIDAY_CALENDAR->value);
    }

    public function manage(User $user): bool
    {
        return $user->isA(Role::MANAGER->value);
    }
}
