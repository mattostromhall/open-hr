<?php

namespace Domain\Organisation\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Organisation\Models\Department;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
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
        return $user->can(Ability::CREATE_DEPARTMENT->value);
    }

    public function viewAll(User $user): bool
    {
        return $user->can(Ability::VIEW_DEPARTMENT->value);
    }

    public function view(User $user, Department $department): bool
    {
        return $user->can(Ability::VIEW_DEPARTMENT->value)
            && $department->isHead($user->person);
    }

    public function update(User $user, Department $department): bool
    {
        return $user->can(Ability::UPDATE_DEPARTMENT->value)
            && $department->isHead($user->person);
    }

    public function delete(User $user): bool
    {
        return $user->can(Ability::DELETE_DEPARTMENT->value);
    }

    public function dashboard(User $user): bool
    {
        return $user->isA(Role::HEAD_OF_DEPARTMENT->value);
    }

    public function manageMembers(User $user, Department $department): bool
    {
        return $user->can(Ability::MANAGE_DEPARTMENT_MEMBERS->value)
            && $department->isHead($user->person);
    }
}
