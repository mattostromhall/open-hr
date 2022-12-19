<?php

use Support\Actions\DeleteReportAction;
use Support\Models\Report;

it('deletes the report', function () {
    $report = Report::factory()->create();

    $action = app(DeleteReportAction::class);

    $this->assertNotSoftDeleted($report);

    $action->execute($report);

    $this->assertSoftDeleted($report);
});
