<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UpdateActiveAction
{
    public function execute(User $user, bool $active): bool
    {
        return $user->update([
            'active' => $active
        ]);
    }
}
