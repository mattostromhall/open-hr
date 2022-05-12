<?php

namespace App\Http\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email']
        ];
    }
}
