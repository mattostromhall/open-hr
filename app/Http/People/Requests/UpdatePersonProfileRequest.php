<?php

namespace App\Http\People\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class UpdatePersonProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'min:2', 'max:20', 'nullable'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'initials' => ['string', 'nullable'],
            'pronouns' => ['string', 'nullable'],
            'dob' => ['required', 'date'],
            'contact_number' => ['required', 'string', 'min:2', 'max:20', Rule::unique('people')->ignore($this->person->id)],
            'contact_email' => ['required', 'email', 'max:255', Rule::unique('people')->ignore($this->person->id)]
        ];
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
                'contact_number',
                'contact_email'
            ]),
            [
                'dob' => Carbon::parse($this->dob),
            ]
        );
    }
}