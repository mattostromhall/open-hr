<?php

namespace Domain\Auth\Actions;

use Illuminate\Support\Facades\Hash;
use Domain\Auth\DataTransferObjects\UserData;

class ResetPasswordAction
{
    public function execute(UserData $data)
    {
        return config('user')::create([
            'email' => $data->email,
            'password' => Hash::make($data->password)
        ]);
    }
}
