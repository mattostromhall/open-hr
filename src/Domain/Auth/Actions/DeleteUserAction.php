<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Actions\Contracts\DeleteUserActionInterface;
use Domain\Auth\Models\User;

class DeleteUserAction implements DeleteUserActionInterface
{
    public function execute(User $user): bool
    {
        return $user->delete();
    }
}
