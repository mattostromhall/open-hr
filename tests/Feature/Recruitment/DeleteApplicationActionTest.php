<?php

use Domain\Recruitment\Actions\DeleteApplicationAction;
use Domain\Recruitment\Models\Application;

it('deletes the application', function () {
    $application = Application::factory()->create();

    $action = app(DeleteApplicationAction::class);

    $this->assertNotSoftDeleted($application);

    $action->execute($application);

    $this->assertSoftDeleted($application);
});
