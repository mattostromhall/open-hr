<?php

namespace App\Http\Departments\Requests;

use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
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

    public function validatedData(): array
    {
        return array_merge(
            $this->safe([
                'name'
            ]),
            [
                'head' => Person::find($this->head_of_department_id)
            ]
        );
    }
}
