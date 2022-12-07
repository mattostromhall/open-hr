<?php

namespace Domain\Recruitment\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Recruitment\Models\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function viewAll(User $user): bool
    {
        return $user->can(Ability::VIEW_VACANCIES->value);
    }

    public function view(User $user, Vacancy $vacancy): bool
    {
        return $user->can(Ability::VIEW_VACANCY->value)
            && $user->person->owns($vacancy, 'contact_id');
    }

    public function create(User $user): bool
    {
        return $user->can(Ability::CREATE_VACANCY->value);
    }

    public function update(User $user, Vacancy $vacancy): bool
    {
        return $user->can(Ability::UPDATE_VACANCY->value)
            && $user->person->owns($vacancy, 'contact_id');
    }

    public function delete(User $user, Vacancy $vacancy): bool
    {
        return $user->can(Ability::DELETE_VACANCY->value)
            && $user->person->owns($vacancy, 'contact_id');
    }
}
