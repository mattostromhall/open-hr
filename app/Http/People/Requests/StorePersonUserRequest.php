<?php

namespace App\Http\People\Requests;

use Domain\Auth\DataTransferObjects\UserData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StorePersonUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'contact_number' => ['required', 'string', 'min:2', 'max:20', 'unique:hr'],
            'contact_email' => ['required', 'email', 'max:255', 'unique:hr'],
        ];
    }

    public function validatedData(): array
    {
        return [
            'user_data' => UserData::from($this->safe(['email', 'password']))
        ] + $this->safe(['contact_number', 'contact_email']);
    }
}