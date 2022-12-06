<?php

namespace Domain\Performance\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Performance\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function view(User $user, Task $task): bool
    {
        $objective = $task->objective;

        return $user->can(Ability::VIEW_TASK->value)
            && (
                $user->person->owns($objective)
                || $user->person->isManagerFor($objective->person)
                || $user->person->isHeadOfDepartmentFor($objective->person)
            );
    }

    public function create(User $user): bool
    {
        return $user->can(Ability::CREATE_TASK->value);
    }

    public function update(User $user, Task $task): bool
    {
        $objective = $task->objective;

        return $user->can(Ability::UPDATE_TASK->value)
            && (
                $user->person->owns($objective)
                || $user->person->isManagerFor($objective->person)
                || $user->person->isHeadOfDepartmentFor($objective->person)
            );
    }

    public function delete(User $user, Task $task): bool
    {
        $objective = $task->objective;

        return $user->can(Ability::DELETE_TASK->value)
            && (
                $user->person->owns($objective)
                || $user->person->isManagerFor($objective->person)
                || $user->person->isHeadOfDepartmentFor($objective->person)
            );
    }

    public function complete(User $user, Task $task): bool
    {
        $objective = $task->objective;

        return $user->can(Ability::COMPLETE_TASK->value)
            && (
                $user->person->owns($objective)
                || $user->person->isManagerFor($objective->person)
                || $user->person->isHeadOfDepartmentFor($objective->person)
            );
    }
}
