<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Actions\Contracts\UpdatePasswordActionInterface;
use Domain\Auth\Models\User;

class UpdatePasswordAction implements UpdatePasswordActionInterface
{
    public function execute(User $user, string $password): bool
    {
        return $user->update([
            'password' => $password
        ]);
    }
}
