<?php

namespace App\Http\People\Requests;

use Domain\People\DataTransferObjects\AddressData;
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

    public function addressData(): AddressData
    {
        return AddressData::from([
            'person' => Person::find($this->person) ?? $this->address->person,
            ...$this->safe()->all()
        ]);
    }
}
