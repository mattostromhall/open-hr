<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Actions\Contracts\UpdateActiveActionInterface;
use Domain\Auth\Models\User;

class UpdateActiveAction implements UpdateActiveActionInterface
{
    public function execute(User $user, bool $active): bool
    {
        return $user->update([
            'active' => $active
        ]);
    }
}
