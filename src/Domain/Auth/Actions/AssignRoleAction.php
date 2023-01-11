<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Actions\Contracts\AssignRoleActionInterface;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;

class AssignRoleAction implements AssignRoleActionInterface
{
    public function execute(User $user, Role $role): User
    {
        return $user->assign($role->value);
    }
}
