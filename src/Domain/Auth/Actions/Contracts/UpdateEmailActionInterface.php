<?php

namespace Domain\Auth\Actions\Contracts;

use Domain\Auth\Models\User;

interface UpdateEmailActionInterface
{
    public function execute(User $user, string $email): bool;
}
