<?php

namespace App\Http\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Support\DataTransferObjects\ReportConditionSetData;
use Support\DataTransferObjects\ReportData;

class ReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'label' => ['sometimes', 'required', 'string', 'max:255'],
            'model' => ['required', 'string', Rule::in(array_keys(config('hr.reportable')))],
            'condition_sets' => ['required', 'array'],
            'condition_sets.*.conditions' => ['required', 'array'],
            'condition_sets.*.type' => ['required', 'in:and,or'],
            'condition_sets.*.conditions.*.column' => ['required', 'string'],
            'condition_sets.*.conditions.*.operator' => ['required', 'string'],
            'condition_sets.*.conditions.*.value' => ['nullable', function ($attribute, $value, $fail) {
                if (! is_string($value) && ! is_numeric($value)) {
                    $fail('The '.$attribute.' must be a string or a number.');
                }
            }]
        ];
    }

    public function attributes(): array
    {
        return [
            'condition_sets.*.conditions.*.column' => 'column',
            'condition_sets.*.conditions.*.operator' => 'operator',
            'condition_sets.*.conditions.*.value' => 'value',
        ];
    }

    public function reportData(): ReportData
    {
        return new ReportData(
            model: $this->validated('model'),
            condition_sets: collect($this->validated('condition_sets'))
                ->map(
                    fn (array $conditionSet) =>
                    ReportConditionSetData::fromArray($conditionSet)
                ),
            label: $this->validated('label')
        );
    }
}
