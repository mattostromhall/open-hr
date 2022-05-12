<?php

namespace App\Http\HR\Requests;

use Domain\Auth\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreHRRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user' => ['required', 'int', 'unique:hr'],
            'contact_number' => ['required', 'string', 'min:2', 'max:20', 'unique:hr'],
            'contact_email' => ['required', 'string', 'email', 'max:255', 'unique:hr'],
        ];
    }

    protected function passedValidation()
    {
        $this->merge(['user' => User::find($this->user)]);
    }
}
