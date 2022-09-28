<?php

namespace App\Http\Expenses\Requests;

use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class ExpenseTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'max:255', Rule::unique('expense_types')->ignore($this->expense_type?->id)],
        ];
    }
}
