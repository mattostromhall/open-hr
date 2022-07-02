<?php

namespace Domain\Auth\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserQueryBuilder extends Builder
{
    public function assignedRoles()
    {
        return $this->model
            ->getRoles()
            ->map(fn ($role) => $role->only('name', 'title'));
    }

    public function assignedAbilities()
    {
        return $this->model
            ->getAbilities()
            ->map(fn ($role) => $role->only('name', 'title'));
    }
}
