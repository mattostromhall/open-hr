<?php

namespace App\Http\Expenses\Requests;

use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Models\ExpenseType;
use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;

class SubmitExpenseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'person_id' => ['required', 'numeric'],
            'expense_type_id' => ['required', 'numeric'],
            'status' => ['required', new Enum(ExpenseStatus::class)],
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'notes' => ['string', 'nullable'],
            'documents' => ['required', 'array', 'min:1', 'max:10'],
            'documents.*' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,docx', 'max:20000']
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
                        'person' => Person::query()->find($this->validated('person_id')),
                        'type' => ExpenseType::query()->find($this->validated('expense_type_id')),
                        'status' => ExpenseStatus::from($this->validated('status')),
                        'date' => Carbon::parse($this->validated('date'))
                    ]
                )
            ),
            'documents' => collect($this->validated('documents'))
        ];
    }
}
