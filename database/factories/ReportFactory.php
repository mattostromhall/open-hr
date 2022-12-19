<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Support\DataTransferObjects\ReportConditionData;
use Support\DataTransferObjects\ReportConditionSetData;
use Support\Models\Report;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'model' => 'objective',
            'condition_sets' => collect([new ReportConditionSetData(
                conditions: collect([new ReportConditionData(
                    column: 'title',
                    operator: '=',
                    value: 'Objective One'
                )])
            ), new ReportConditionSetData(
                conditions: collect([new ReportConditionData(
                    column: 'title',
                    operator: '=',
                    value: 'Objective Two'
                )]),
                type: 'or'
            ), new ReportConditionSetData(
                conditions: collect([new ReportConditionData(
                    column: 'title',
                    operator: '=',
                    value: 'Objective Three'
                )]),
                type: 'or'
            )])
        ];
    }
}
