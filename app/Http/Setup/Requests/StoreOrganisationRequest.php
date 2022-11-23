<?php

namespace App\Http\Setup\Requests;

use Domain\Organisation\DataTransferObjects\OrganisationData;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrganisationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2'],
            'logo' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:20000']
        ];
    }

    public function organisationData(): OrganisationData
    {
        return OrganisationData::from($this->safe()->all());
    }
}
