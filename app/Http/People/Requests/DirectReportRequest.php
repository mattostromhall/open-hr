<?php

namespace App\Http\People\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DirectReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'direct_reports' => ['required', 'array'],
            'direct_reports.*' => ['numeric']
        ];
    }
}
