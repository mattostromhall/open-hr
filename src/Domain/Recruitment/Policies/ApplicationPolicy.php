<?php

namespace Domain\Recruitment\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Recruitment\Models\Application;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function view(User $user, Application $application): bool
    {
        return $user->can(Ability::VIEW_APPLICATION->value)
            && $user->person->owns($application->vacancy, 'contact_id');
    }

    public function update(User $user, Application $application): bool
    {
        return $user->can(Ability::UPDATE_APPLICATION->value)
            && $user->person->owns($application->vacancy, 'contact_id');
    }

    public function delete(User $user, Application $application): bool
    {
        return $user->can(Ability::DELETE_APPLICATION->value)
            && $user->person->owns($application->vacancy, 'contact_id');
    }
}
