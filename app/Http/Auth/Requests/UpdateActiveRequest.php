<?php

namespace App\Http\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateActiveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'active' => ['required', 'boolean']
        ];
    }
}
