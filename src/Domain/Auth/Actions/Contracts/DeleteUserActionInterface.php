<?php

namespace Domain\Auth\Actions\Contracts;

use Domain\Auth\Models\User;

interface DeleteUserActionInterface
{
    public function execute(User $user): bool;
}
