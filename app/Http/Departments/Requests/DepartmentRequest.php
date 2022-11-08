<?php

namespace App\Http\Departments\Requests;

use Domain\Organisation\DataTransferObjects\DepartmentData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('departments')->ignore($this->department?->id)],
            'head_of_department_id' => ['required', 'numeric']
        ];
    }

    public function departmentData(): DepartmentData
    {
        return DepartmentData::from($this->safe()->all());
    }
}
