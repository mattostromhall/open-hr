<?php

namespace App\Http\Expenses\Requests;

use Domain\Expenses\DataTransferObjects\ExpenseTypeData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'max:255', Rule::unique('expense_types')->ignore($this->expense_type?->id)],
        ];
    }

    public function expenseTypeData(): ExpenseTypeData
    {
        return ExpenseTypeData::from($this->validated());
    }
}
