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

    public function expenseData(): ExpenseData
    {
        return ExpenseData::from([
            'person' => $this->expense->person,
            ...$this->expense->toArray(),
            ...$this->safe()->all()
        ]);
    }
}
