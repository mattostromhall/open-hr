<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\User;

class DeleteUserAction
{
    public function execute(User $user): bool
    {
        return $user->delete();
    }
}
