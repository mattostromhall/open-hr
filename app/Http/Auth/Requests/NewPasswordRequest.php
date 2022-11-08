<?php

namespace App\Http\Auth\Requests;

use Domain\Auth\DataTransferObjects\ResetPasswordData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class NewPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function resetPasswordData(): ResetPasswordData
    {
        return ResetPasswordData::from([
            'email' => $this->validated('email,'),
            'password' => $this->validated('password,'),
            'password_confirmation' => $this->validated('password_confirmation,'),
            'token' => $this->validated('token')
        ]);
    }

    public function data(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token
        ];
    }
}
