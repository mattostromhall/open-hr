<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Actions\Contracts\ResetPasswordActionInterface;
use Domain\Auth\DataTransferObjects\ResetPasswordData;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordAction implements ResetPasswordActionInterface
{
    public function execute(ResetPasswordData $data): mixed
    {
        return Password::reset(
            [$data->email, $data->password, $data->password_confirmation, $data->token],
            function ($user) use ($data) {
                $user->forceFill([
                    'password' => Hash::make($data->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );
    }
}
