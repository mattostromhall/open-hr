<?php

namespace Domain\Expenses\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Expenses\Models\Expense;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensePolicy
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
        return $user->can(Ability::CREATE_EXPENSE->value);
    }

    public function view(User $user, Expense $expense): bool
    {
        return $user->can(Ability::VIEW_EXPENSE->value)
            && (
                $user->person->owns($expense)
                || $user->person->isManagerFor($expense->person)
                || $user->person->isHeadOfDepartmentFor($expense->person)
            );
    }

    public function update(User $user, Expense $expense): bool
    {
        return $user->can(Ability::UPDATE_EXPENSE->value)
            && (
                $user->person->owns($expense)
                || $user->person->isManagerFor($expense->person)
                || $user->person->isHeadOfDepartmentFor($expense->person)
            );
    }

    public function delete(User $user, Expense $expense): bool
    {
        return $user->can(Ability::DELETE_EXPENSE->value)
            && (
                $user->person->owns($expense)
                || $user->person->isManagerFor($expense->person)
                || $user->person->isHeadOfDepartmentFor($expense->person)
            );
    }
}
