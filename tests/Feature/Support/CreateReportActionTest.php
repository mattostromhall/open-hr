<?php

use Support\Actions\CreateReportAction;
use Support\DataTransferObjects\ReportConditionData;
use Support\DataTransferObjects\ReportConditionSetData;

use Support\DataTransferObjects\ReportData;

it('saves a report', function () {
    $action = app(CreateReportAction::class);
    $reportData = new ReportData(
        model: 'objective',
        condition_sets: collect([new ReportConditionSetData(
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
        )]),
        label: 'Test Report'
    );

    $action->execute($reportData);

    $this->assertDatabaseHas('reports', [
        'label' => $reportData->label,
        'model' => $reportData->model,
        'condition_sets' => json_encode($reportData->condition_sets)
    ]);
});
