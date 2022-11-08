<?php

namespace App\Http\Expenses\Requests;

use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\DataTransferObjects\SubmittedExpenseData;
use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Models\ExpenseType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;
use Support\Enums\Currency;

class UpdateExpenseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'expense_type_id' => ['required', 'numeric'],
            'status' => ['required', new Enum(ExpenseStatus::class)],
            'value' => ['required', 'numeric'],
            'value_currency' => ['required', new Enum(Currency::class)],
            'date' => ['required', 'date'],
            'notes' => ['string', 'nullable'],
            'documents' => ['array', 'min:1', 'max:10', 'nullable'],
            'documents.*' => ['file', 'mimes:jpg,jpeg,png,pdf,docx', 'max:20000']
        ];
    }

    public function submittedExpenseData(): SubmittedExpenseData
    {
        return SubmittedExpenseData::from([
            'expense_data' => ExpenseData::from([
                'person' => $this->expense->person,
                ...$this->safe()->all()
            ]),
            'documents' => collect($this->validated('documents'))
        ]);
    }
}
