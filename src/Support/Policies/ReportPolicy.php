<?php

namespace Support\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function view(User $user): bool
    {
        return $user->can(Ability::VIEW_REPORT->value);
    }

    public function create(User $user): bool
    {
        return $user->can(Ability::CREATE_REPORT->value);
    }

    public function update(User $user): bool
    {
        return $user->can(Ability::UPDATE_REPORT->value);
    }

    public function delete(User $user): bool
    {
        return $user->can(Ability::DELETE_REPORT->value);
    }
}
