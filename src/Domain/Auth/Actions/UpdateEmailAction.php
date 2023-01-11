<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Actions\Contracts\UpdateEmailActionInterface;
use Domain\Auth\Models\User;

class UpdateEmailAction implements UpdateEmailActionInterface
{
    public function execute(User $user, string $email): bool
    {
        return $user->update([
            'email' => $email
        ]);
    }
}
