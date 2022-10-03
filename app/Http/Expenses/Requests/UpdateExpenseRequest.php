<?php

namespace App\Http\Expenses\Requests;

use Domain\Expenses\DataTransferObjects\ExpenseData;
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

    public function validatedData(): array
    {
        return [
            'expense_data' => ExpenseData::from(
                array_merge(
                    $this->safe([
                        'value',
                        'notes'
                    ]),
                    [
                        'person' => $this->expense->person,
                        'type' => ExpenseType::query()->find($this->validated('expense_type_id')),
                        'status' => ExpenseStatus::from($this->validated('status')),
                        'value_currency' => Currency::from($this->validated('value_currency')),
                        'date' => Carbon::parse($this->validated('date'))
                    ]
                )
            ),
            'documents' => collect($this->validated('documents'))
        ];
    }
}
