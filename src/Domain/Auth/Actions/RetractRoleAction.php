<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Actions\Contracts\RetractRoleActionInterface;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;

class RetractRoleAction implements RetractRoleActionInterface
{
    public function execute(User $user, Role $role): User
    {
        return $user->retract($role->value);
    }
}
