<?php

namespace App\Http\Expenses\Requests;

use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Models\ExpenseType;
use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;
use Support\Enums\Currency;

class ReviewExpenseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'expense_type_id' => ['required', 'numeric'],
            'status' => ['required', new Enum(ExpenseStatus::class)],
            'notes' => ['string', 'nullable']
        ];
    }

    public function validatedData(): array
    {
        return array_merge(
            $this->safe([
                'notes'
            ]),
            [
                'person' => $this->expense->person,
                'type' => ExpenseType::query()->find($this->validated('expense_type_id')),
                'status' => ExpenseStatus::from($this->validated('status'))
            ]
        );
    }
}
