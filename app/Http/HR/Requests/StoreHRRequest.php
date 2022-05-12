<?php

namespace App\Http\HR\Requests;

use Domain\Auth\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreHRRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'int', 'unique:hr'],
            'contact_number' => ['required', 'string', 'min:2', 'max:20', 'unique:hr'],
            'contact_email' => ['required', 'string', 'email', 'max:255', 'unique:hr'],
        ];
    }

    public function validatedWithUser(): array
    {
        return [
            'user' => User::find($this->validated('user_id'))
        ] + $this->safe(['contact_number', 'contact_email']);
    }
}
