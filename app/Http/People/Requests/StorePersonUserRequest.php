<?php

namespace App\Http\People\Requests;

use Domain\Auth\DataTransferObjects\UserData;
use Domain\Auth\Models\User;
use Domain\Organisation\Models\Department;
use Domain\People\DataTransferObjects\PersonUserData;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Support\Enums\Currency;

class StorePersonUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // User
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'active' => ['boolean'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'reset_required' => ['boolean'],
            // Person
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

    public function personUserData(): PersonUserData
    {
        return PersonUserData::from([
            'user_data' => UserData::from(
                $this->safe([
                    'email',
                    'active',
                    'password',
                    'reset_required'
                ])
            ),
            ...$this->safe([
                'manager_id',
                'department_id',
                'title',
                'first_name',
                'last_name',
                'initials',
                'pronouns',
                'dob',
                'position',
                'remuneration',
                'remuneration_interval',
                'remuneration_currency',
                'base_holiday_allocation',
                'holiday_carry_allocation',
                'holiday_carried',
                'sickness_allocation',
                'contact_number',
                'contact_email',
                'started_on',
                'finished_on'
            ])
        ]);
    }
}
