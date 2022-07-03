<?php

namespace Domain\Auth\QueryBuilders;

use Domain\Auth\DataTransferObjects\AbilityData;
use Domain\Auth\DataTransferObjects\RoleData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class UserQueryBuilder extends Builder
{
    public function assignedRoles()
    {
        return $this->model
            ->getRoles()
            ->map(
                fn ($role) => new RoleData(
                    name: $role,
                    title: Str::of($role)->replace('-', ' ')->ucfirst()
                )
            );

    }

    public function assignedAbilities()
    {
        return $this->model
            ->getAbilities()
            ->map(
                fn ($role) => AbilityData::from($role->only('name', 'title'))
            );
    }
}
