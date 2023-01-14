<?php

namespace App\Http\People\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeletePeopleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'people' => ['required', 'array'],
            'people.*' => ['numeric']
        ];
    }
}
