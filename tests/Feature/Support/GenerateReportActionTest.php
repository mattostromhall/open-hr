<?php

use Illuminate\Support\Facades\Storage;
use Support\Actions\GenerateReportAction;
use Support\DataTransferObjects\ReportConditionData;
use Support\DataTransferObjects\ReportConditionSetData;
use Support\DataTransferObjects\ReportData;

it('generates the report', function () {
    $action = app(GenerateReportAction::class);
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
        label: 'test-report'
    );

    $result = $action->execute($reportData);

    Storage::assertExists($result);
});

afterEach(function () {
    Storage::deleteDirectory('reports');
});
