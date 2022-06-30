<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UpdatePasswordAction
{
    public function execute(User $user, string $password): bool
    {
        return $user->update([
            'password' => $password
        ]);
    }
}
