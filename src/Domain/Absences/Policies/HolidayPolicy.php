<?php

namespace Domain\Absences\Policies;

use Domain\Absences\Models\Holiday;
use Domain\Auth\Enums\Ability;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HolidayPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function review(User $user, Holiday $holiday): bool
    {
        return $user->can(Ability::REVIEW_HOLIDAY->value)
            && (
                $user->person->isManagerFor($holiday->person)
                || $user->person->isHeadOfDepartmentFor($holiday->person)
            );
    }
}
