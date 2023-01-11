<?php

namespace Domain\Auth\Actions\Contracts;

use Domain\Auth\DataTransferObjects\UserData;
use Domain\Auth\Models\User;

interface CreateUserActionInterface
{
    public function execute(UserData $data): User;
}
