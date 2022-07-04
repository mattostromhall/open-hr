<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;

class SyncRolesAction
{
    public function execute(User $user, array $roles): User
    {
//        return $user->assign($role->value);
    }
}
