<?php

namespace Domain\Auth\Actions\Contracts;

use Domain\Auth\Models\User;

interface SyncRolesActionInterface
{
    public function execute(User $user, array $roles): void;
}
