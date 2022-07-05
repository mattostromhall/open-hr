<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;

class RetractRoleAction
{
    public function execute(User $user, Role $role): User
    {
        return $user->retract($role->value);
    }
}
