<?php

namespace Domain\People\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\People\Models\Address;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
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
        return $user->can(Ability::CREATE_ADDRESS->value);
    }

    public function update(User $user, Address $address): bool
    {
        return $user->can(Ability::UPDATE_ADDRESS->value)
            && (
                $user->person->owns($address)
                || $user->person->isManagerFor($address->person)
                || $user->person->isHeadOfDepartmentFor($address->person)
            );
    }

    public function delete(User $user, Address $address): bool
    {
        return $user->can(Ability::DELETE_ADDRESS->value)
            && (
                $user->person->owns($address)
                || $user->person->isManagerFor($address->person)
                || $user->person->isHeadOfDepartmentFor($address->person)
            );
    }
}
