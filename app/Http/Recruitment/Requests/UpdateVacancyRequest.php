<?php

namespace App\Http\Recruitment\Requests;

use Domain\People\Models\Person;
use Domain\Recruitment\DataTransferObjects\VacancyData;
use Domain\Recruitment\Enums\ContractType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Support\Enums\Currency;

class UpdateVacancyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'contact_id' => ['numeric', 'exists:people,id'],
            'title' => ['string', 'max:255'],
            'description' => ['string'],
            'location' => ['string', 'max:255', 'nullable'],
            'contract_type' => [new Enum(ContractType::class), 'nullable'],
            'contract_length' => ['string', 'max:255', 'nullable'],
            'remuneration' => ['numeric', 'nullable'],
            'remuneration_currency' => [new Enum(Currency::class), 'nullable'],
            'open_at' => ['date', 'nullable'],
            'close_at' => ['date', 'after_or_equal:open_at', 'required_with:open_at', 'nullable']
        ];
    }

    public function vacancyData(): VacancyData
    {
        return VacancyData::from([
            ...$this->vacancy->toArray(),
            ...$this->safe()->all()
        ]);
    }
}
