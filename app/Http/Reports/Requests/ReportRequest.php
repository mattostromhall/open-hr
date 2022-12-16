<?php

namespace App\Http\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Support\DataTransferObjects\ReportConditionData;
use Support\DataTransferObjects\ReportConditionSetData;
use Support\DataTransferObjects\ReportData;

class ReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'label' => ['sometimes', 'required', 'string', 'max:255'],
            'model' => ['required', 'string', Rule::in(array_keys(config('app.reportable')))],
            'condition_sets' => ['required', 'array'],
            'condition_sets.*.conditions' => ['required', 'array'],
            'condition_sets.*.type' => ['required', 'in:and,or'],
            'condition_sets.*.conditions.*.column' => ['required', 'string'],
            'condition_sets.*.conditions.*.operator' => ['required', 'string'],
            'condition_sets.*.conditions.*.value' => ['string', 'nullable']
        ];
    }

    public function reportData(): ReportData
    {
        return new ReportData(
            model: config('app.reportable')[$this->validated('model')],
            condition_sets: collect($this->validated('condition_sets'))
                ->map(
                    fn (array $conditionSet) =>
                    ReportConditionSetData::fromArray($conditionSet)
                ),
            label: $this->validated('label')
        );
    }
}
