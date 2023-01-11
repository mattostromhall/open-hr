<?php

namespace Domain\Auth\Actions\Contracts;

use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;

interface AssignRoleActionInterface
{
    public function execute(User $user, Role $role): User;
}
