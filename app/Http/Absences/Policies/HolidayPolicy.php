<?php

namespace App\Http\Absences\Policies;

use Domain\Absences\Models\Holiday;
use Domain\Auth\Enums\Ability;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HolidayPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show(User $user, Holiday $holiday): bool
    {
        return $user->can(Ability::REVIEW_HOLIDAY->value);
    }
}
