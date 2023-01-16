<?php

use Support\Actions\BulkDeleteReportsAction;
use Support\Models\Report;

it('bulk deletes the reports', function () {
    $reports = Report::factory()->count(3)->create();
    $action = app(BulkDeleteReportsAction::class);

    $reports->each(fn (Report $report) => $this->assertNotSoftDeleted($report));

    $action->execute($reports->pluck('id')->toArray());

    $reports->each(fn (Report $report) => $this->assertSoftDeleted($report));
});
