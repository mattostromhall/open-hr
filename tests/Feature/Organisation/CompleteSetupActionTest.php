<?php

use Domain\Organisation\Actions\CompleteSetupAction;
use Domain\Organisation\Models\Organisation;

it('marks the organisation as having completed setup', function () {
    $organisation = Organisation::factory()->create([
        'setup_at' => null
    ]);

    $action = app(CompleteSetupAction::class);

    $action->execute();

    $this->assertNotNull($organisation->refresh()->setup_at);
});
