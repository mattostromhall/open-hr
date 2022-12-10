<?php

namespace App\Http\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Support\DataTransferObjects\ReportData;

class ReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'model' => ['required', 'string', Rule::in(array_keys(config('app.reportable')))],
            'conditionSets' => ['required', 'array'],
            'conditionSets.*.conditions' => ['required', 'array'],
            'conditionSets.*.type' => ['required', 'string'],
            'conditionSets.*.conditions.*.column' => ['required', 'string'],
            'conditionSets.*.conditions.*.operator' => ['required', 'string'],
            'conditionSets.*.conditions.*.value' => ['regex:/^[a-z0-9\s]*$/i', 'nullable']
        ];
    }

    public function reportData(): ReportData
    {
        return new ReportData();
    }
}
