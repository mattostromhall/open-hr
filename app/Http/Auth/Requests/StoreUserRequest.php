<?php

namespace App\Http\Auth\Requests;

use Domain\Auth\DataTransferObjects\UserData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'active' => ['boolean'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'reset_required' => ['boolean']
        ];
    }

    public function userData(): UserData
    {
        return UserData::from($this->validated());
    }
}
