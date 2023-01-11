<?php

namespace Domain\Auth\Actions\Contracts;

use Domain\Auth\Models\User;

interface UpdateActiveActionInterface
{
    public function execute(User $user, bool $active): bool;
}
