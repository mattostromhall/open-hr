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

    public function view(User $user, Department $department): bool
    {
        return $user->can(Ability::VIEW_DEPARTMENT->value)
            && $user->person->id === $department->head_of_department_id;
    }

    public function update(User $user, Department $department): bool
    {
        return $user->can(Ability::UPDATE_DEPARTMENT->value)
            && $user->person->id === $department->head_of_department_id;
    }

    public function delete(User $user, Department $department): bool
    {
        return $user->can(Ability::DELETE_DEPARTMENT->value)
            && $user->person->id === $department->head_of_department_id;
    }

    public function dashboard(User $user): bool
    {
        return $user->isA(Role::HEAD_OF_DEPARTMENT->value);
    }
}
