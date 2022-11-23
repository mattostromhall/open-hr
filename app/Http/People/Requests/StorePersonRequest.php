<?php

namespace App\Http\People\Requests;

use Domain\Auth\Models\User;
use Domain\Organisation\Models\Department;
use Domain\People\DataTransferObjects\PersonData;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;
use Support\Enums\Currency;

class StorePersonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'numeric', 'unique:people'],
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
            'contact_number' => ['required', 'string', 'min:2', 'max:20', 'unique:people'],
            'contact_email' => ['required', 'email', 'max:255', 'unique:people'],
            'started_on' => ['required', 'date'],
            'finished_on' => ['date', 'nullable', 'after:started_on']
        ];
    }

    public function personData(): PersonData
    {
        return PersonData::from($this->safe()->all());
    }

    public function validatedData(): array
    {
        return array_merge(
            $this->safe([
                'title',
                'first_name',
                'last_name',
                'initials',
                'pronouns',
                'position',
                'remuneration',
                'base_holiday_allocation',
                'holiday_carry_allocation',
                'holiday_carried',
                'sickness_allocation',
                'contact_number',
                'contact_email'
            ]),
            [
                'user' => User::find($this->validated('user_id')),
                'manager' => Person::find($this->validated('manager_id')),
                'department' => Department::find($this->validated('department_id')),
                'dob' => Carbon::parse($this->validated('dob')),
                'remuneration_interval' => RemunerationInterval::from($this->validated('remuneration_interval')),
                'remuneration_currency' => Currency::from($this->validated('remuneration_currency')),
                'started_on' => Carbon::parse($this->validated('started_on')),
                'finished_on' => $this->validated('finished_on')
                    ? Carbon::parse($this->validated('finished_on'))
                    : null
            ]
        );
    }
}
