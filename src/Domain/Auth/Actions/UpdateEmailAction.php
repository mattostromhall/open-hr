<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UpdateEmailAction
{
    public function execute(User|Authenticatable $user, string $email): bool
    {
        return $user->update([
            'email' => $email
        ]);
    }
}
