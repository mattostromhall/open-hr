<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\User;

class AssignHrRoleAction
{
    public function execute(User $user): User
    {
        return $user->assign('hr');
    }
}
