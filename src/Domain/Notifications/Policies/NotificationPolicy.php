<?php

namespace Domain\Notifications\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Notifications\Models\Notification;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function organisationCreate(User $user): bool
    {
        return $user->can(Ability::CREATE_ORGANISATION_NOTIFICATION->value);
    }

    public function departmentCreate(User $user): bool
    {
        return $user->can(Ability::CREATE_DEPARTMENT_NOTIFICATION->value);
    }

    public function delete(User $user, Notification $notification): bool
    {
        $notifiable = $notification->notifiable;

        return match (get_class($notifiable)) {
            Organisation::class => $user->can(Ability::DELETE_ORGANISATION_NOTIFICATION->value),
            Department::class => $notifiable->isHead($user->person) && $user->can(Ability::DELETE_DEPARTMENT_NOTIFICATION->value),
            default => false
        };
    }
}
