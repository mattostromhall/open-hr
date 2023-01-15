<?php

namespace App\Http\Departments\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteDepartmentsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'departments' => ['required', 'array'],
            'departments.*' => ['numeric']
        ];
    }
}
