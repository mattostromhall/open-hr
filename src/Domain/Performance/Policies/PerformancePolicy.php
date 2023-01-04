<?php

namespace Domain\Performance\Policies;

use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PerformancePolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function manage(User $user): bool
    {
        return $user->isA(Role::MANAGER->value);
    }
}
