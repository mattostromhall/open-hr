<?php

use Support\Actions\UpdateReportAction;
use Support\DataTransferObjects\ReportConditionData;
use Support\DataTransferObjects\ReportConditionSetData;
use Support\DataTransferObjects\ReportData;
use Support\Models\Report;

it('updates the report', function () {
    $report = Report::factory()->create();

    $action = app(UpdateReportAction::class);
    $reportData = new ReportData(
        model: 'objective',
        condition_sets: collect([new ReportConditionSetData(
            conditions: collect([new ReportConditionData(
                column: 'title',
                operator: '=',
                value: 'Objective One Updated'
            )])
        ), new ReportConditionSetData(
            conditions: collect([new ReportConditionData(
                column: 'title',
                operator: '=',
                value: 'Objective Two Updated'
            )]),
            type: 'or'
        )]),
        label: 'Test Report'
    );

    $this->assertModelExists($report);

    $action->execute($report, $reportData);

    $this->assertDatabaseHas('reports', [
        'label' => $reportData->label,
        'model' => $reportData->model,
        'condition_sets' => json_encode($reportData->condition_sets)
    ]);
});
