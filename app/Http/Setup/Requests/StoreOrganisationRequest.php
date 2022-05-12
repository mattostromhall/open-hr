<?php

namespace App\Http\Setup\Requests;

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
}
