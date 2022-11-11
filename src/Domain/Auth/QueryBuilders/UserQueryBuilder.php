<?php

namespace Domain\Auth\QueryBuilders;

use Domain\Auth\DataTransferObjects\AbilityData;
use Domain\Auth\DataTransferObjects\RoleData;
use Domain\People\QueryBuilders\PersonQueryBuilder;
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
                    title: Str::of($role)->replace('-', ' ')->ucfirst(),
                    abilities: $this->assignedAbilities()
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

    public function filter(string $search = null): self
    {
        return $this->when(
            $search,
            fn () => $this
                ->where('email', $search)
                ->orWhereHas('person', function (PersonQueryBuilder $query) use ($search) {
                    $query->filter($search);
                })
        );
    }
}
