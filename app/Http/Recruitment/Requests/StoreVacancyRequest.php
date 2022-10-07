<?php

namespace App\Http\Recruitment\Requests;

use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ContractType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;
use Support\Enums\Currency;

class StoreVacancyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'contact_id' => ['required', 'numeric', 'exists:people,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['string', 'max:255', 'nullable'],
            'contract_type' => [new Enum(ContractType::class), 'nullable'],
            'contract_length' => ['string', 'max:255', 'nullable'],
            'remuneration' => ['numeric', 'nullable'],
            'remuneration_currency' => [new Enum(Currency::class), 'nullable'],
            'open_at' => ['date', 'nullable'],
            'close_at' => ['date', 'after_or_equal:open_at', 'required_with:open_at']
        ];
    }

    public function validatedData(): array
    {
        return array_merge(
            $this->safe([
                'title',
                'description',
                'location',
                'contract_length',
                'remuneration'
            ]),
            [
                'contact' => Person::query()->find($this->validated('contact_id')),
                'contract_type' => $this->validated('contract_type') ? ContractType::from($this->validated('contract_type')) : null,
                'remuneration_currency' => $this->validated('remuneration_currency') ? Currency::from($this->validated('remuneration_currency')) : null,
                'open_at' => $this->validated('open_at') ? Carbon::parse($this->validated('open_at')) : null,
                'close_at' => $this->validated('close_at') ? Carbon::parse($this->validated('close_at')) : null
            ]
        );
    }
}
