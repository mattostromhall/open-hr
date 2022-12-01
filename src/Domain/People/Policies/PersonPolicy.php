<?php

namespace Domain\People\Policies;

use Domain\Absences\Models\Holiday;
use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
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

    public function managementDashboard(User $user): bool
    {
        return $user->isA(Role::MANAGER->value)
            || $user->isA(Role::HEAD_OF_DEPARTMENT->value);
    }
}
