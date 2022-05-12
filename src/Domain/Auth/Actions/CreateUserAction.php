<?php

namespace Domain\Auth\Actions;

use Domain\Auth\DataTransferObjects\UserData;
use Domain\Auth\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function execute(UserData $data)
    {
        return User::create([
            'email' => $data->email,
            'password' => Hash::make($data->password)
        ]);
    }
}
