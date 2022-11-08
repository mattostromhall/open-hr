<?php

namespace App\Http\People\Requests;

use Domain\Auth\Models\User;
use Domain\Organisation\Models\Department;
use Domain\People\DataTransferObjects\PersonData;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Support\Enums\Currency;

class UpdatePersonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'numeric'],
            'manager_id' => ['numeric', 'nullable'],
            'department_id' => ['numeric', 'nullable'],
            'title' => ['string', 'min:2', 'max:20', 'nullable'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'initials' => ['string', 'nullable'],
            'pronouns' => ['string', 'nullable'],
            'dob' => ['required', 'date'],
            'position' => ['required', 'string'],
            'remuneration' => ['required', 'numeric'],
            'remuneration_interval' => ['required', new Enum(RemunerationInterval::class)],
            'remuneration_currency' => ['required', new Enum(Currency::class)],
            'base_holiday_allocation' => ['required', 'numeric', 'max:365'],
            'holiday_carry_allocation' => ['numeric', 'max:365'],
            'holiday_carried' => ['numeric', 'max:365'],
            'sickness_allocation' => ['required', 'numeric', 'max:365'],
            'contact_number' => ['required', 'string', 'min:2', 'max:20', Rule::unique('people')->ignore($this->person->id)],
            'contact_email' => ['required', 'email', 'max:255', Rule::unique('people')->ignore($this->person->id)],
            'started_on' => ['required', 'date'],
            'finished_on' => ['date', 'nullable', 'after:started_on'],
            'hex_code' => ['required', 'string', 'min:7', 'max:7', Rule::unique('people')->ignore($this->person->id)]
        ];
    }

    public function personData(): PersonData
    {
        return PersonData::from($this->safe()->all());
    }
}
