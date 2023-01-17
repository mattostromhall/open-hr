<?php

use Domain\Recruitment\Actions\BulkDeleteApplicationsAction;
use Domain\Recruitment\Models\Application;

it('bulk deletes the applications', function () {
    $applications = Application::factory()->count(3)->create();
    $action = app(BulkDeleteApplicationsAction::class);

    $applications->each(fn (Application $application) => $this->assertNotSoftDeleted($application));

    $action->execute($applications->pluck('id')->toArray());

    $applications->each(fn (Application $application) => $this->assertSoftDeleted($application));
});
