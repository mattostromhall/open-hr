<?php

namespace App\Http\Expenses\Requests;

use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\DataTransferObjects\SubmittedExpenseData;
use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Models\ExpenseType;
use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;
use Support\Enums\Currency;

class SubmitExpenseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'person_id' => ['required', 'numeric'],
            'expense_type_id' => ['required', 'numeric'],
            'status' => ['required', new Enum(ExpenseStatus::class)],
            'value' => ['required', 'numeric'],
            'value_currency' => ['required', new Enum(Currency::class)],
            'date' => ['required', 'date'],
            'notes' => ['string', 'nullable'],
            'documents' => ['required', 'array', 'min:1', 'max:10'],
            'documents.*' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,docx', 'max:20000']
        ];
    }

    public function submittedExpenseData(): SubmittedExpenseData
    {
        return SubmittedExpenseData::from([
            'expense_data' => ExpenseData::from($this->safe()->all()),
            'documents' => collect($this->validated('documents'))
        ]);
    }
}
