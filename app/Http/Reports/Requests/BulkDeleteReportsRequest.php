<?php

namespace App\Http\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteReportsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reports' => ['required', 'array'],
            'reports.*' => ['numeric']
        ];
    }
}
