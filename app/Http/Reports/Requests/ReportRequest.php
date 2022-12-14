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
        $conditionSets = collect($this->validated('condition_sets'))
            ->map(
                fn (array $conditionSet) =>
                new ReportConditionSetData(
                    conditions: collect($conditionSet['conditions'])
                        ->map(
                            fn (array $condition) =>
                            new ReportConditionData(
                                column: $condition['column'],
                                operator: $condition['operator'],
                                value: array_key_exists('value', $condition) ? $condition['value'] : null
                            )
                        ),
                    type: $conditionSet['type']
                )
            );

        return new ReportData(
            model: config('app.reportable')[$this->validated('model')],
            conditionSets: $conditionSets
        );
    }
}
