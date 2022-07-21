<?php

namespace App\Http\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'roles' => ['required', 'array'],
            'roles.*' => ['string']
        ];
    }
}
