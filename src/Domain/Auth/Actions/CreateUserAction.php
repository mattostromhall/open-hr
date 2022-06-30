<?php

namespace Domain\Auth\Actions;

use Domain\Auth\DataTransferObjects\UserData;
use Domain\Auth\Models\User;

class CreateUserAction
{
    public function execute(UserData $data): User
    {
        return User::create([
            'email' => $data->email,
            'active' => $data->active,
            'password' => $data->password,
            'reset_required' => $data->reset_required
        ]);
    }
}
