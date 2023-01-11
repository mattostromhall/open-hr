<?php

namespace Domain\Auth\Actions\Contracts;

use Domain\Auth\Models\User;

interface UpdatePasswordActionInterface
{
    public function execute(User $user, string $password): bool;
}
