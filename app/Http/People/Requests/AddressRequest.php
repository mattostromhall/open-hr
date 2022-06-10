<?php

namespace App\Http\People\Requests;

use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address_line' => ['required', 'string'],
            'country' => ['required', 'string'],
            'region' => ['required', 'string'],
            'town_city' => ['required', 'string'],
            'postal_code' => ['required', 'string']
        ];
    }

    public function validatedData(): array
    {
        return array_merge(
            $this->safe([
                'address_line',
                'country',
                'region',
                'town_city',
                'postal_code'
            ]),
            [
                'person' => Person::find($this->person)
            ]
        );
    }
}
