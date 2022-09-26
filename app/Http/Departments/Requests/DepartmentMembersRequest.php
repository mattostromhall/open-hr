<?php

namespace App\Http\Departments\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentMembersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'members' => ['required', 'array'],
            'members.*' => ['numeric']
        ];
    }
}
