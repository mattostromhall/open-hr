<?php

namespace Domain\Expenses\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Expenses\Models\ExpenseType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpenseTypePolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function create(User $user): bool
    {
        return $user->can(Ability::CREATE_EXPENSE_TYPE->value);
    }

    public function view(User $user): bool
    {
        return $user->can(Ability::VIEW_EXPENSE_TYPE->value);
    }

    public function update(User $user): bool
    {
        return $user->can(Ability::UPDATE_EXPENSE_TYPE->value);
    }

    public function delete(User $user): bool
    {
        return $user->can(Ability::DELETE_EXPENSE_TYPE->value);
    }
}
