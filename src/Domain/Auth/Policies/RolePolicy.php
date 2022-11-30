<?php

namespace Domain\Auth\Policies;

use Domain\Absences\Models\Holiday;
use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function sync(User $user): bool
    {
        return $user->can(Ability::ASSIGN_ROLE->value)
            && $user->can(Ability::RETRACT_ROLE->value);
    }
}
