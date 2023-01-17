<?php

namespace App\Http\Recruitment\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteApplicationsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'applications' => ['required', 'array'],
            'applications.*' => ['numeric']
        ];
    }
}
