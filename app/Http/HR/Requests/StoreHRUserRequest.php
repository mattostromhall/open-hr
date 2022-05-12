<?php

namespace App\Http\HR\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreHRUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'contact_number' => ['required', 'string', 'min:2', 'max:20', 'unique:hr'],
            'contact_email' => ['required', 'string', 'email', 'max:255', 'unique:hr'],
        ];
    }
}
