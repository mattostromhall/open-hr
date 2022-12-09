<?php

namespace App\Http\Support\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Support\DataTransferObjects\ReportData;

class ReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'model' => ['required', 'string', Rule::in(array_keys(config('app.reportable')))],
            'conditionGroups' => ['required', 'array'],
            'conditionGroups.*.conditions' => ['required', 'array'],
            'conditionGroups.*.type' => ['required', 'string'],
            'conditionGroups.*.conditions.*.column' => ['required', 'string'],
            'conditionGroups.*.conditions.*.operator' => ['required', 'string'],
            'conditionGroups.*.conditions.*.value' => ['regex:/^[a-z0-9\s]*$/i', 'nullable']
        ];
    }

    public function reportData(): ReportData
    {
        return new ReportData();
    }
}
