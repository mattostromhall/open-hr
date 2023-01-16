<?php

namespace App\Http\Expenses\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteExpenseTypesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'expenseTypes' => ['required', 'array'],
            'expenseTypes.*' => ['numeric']
        ];
    }
}
