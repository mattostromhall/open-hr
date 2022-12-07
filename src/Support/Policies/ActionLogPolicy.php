<?php

namespace Support\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActionLogPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function view(User $user): bool
    {
        return $user->can(Ability::VIEW_ACTION_LOGS->value);
    }
}
