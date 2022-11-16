<?php

use Domain\Absences\Actions\DeleteSicknessAction;
use Domain\Absences\Models\Sickness;

it('deletes the sickness', function () {
    $sickness = Sickness::factory()->create();

    $action = app(DeleteSicknessAction::class);

    $this->assertNotSoftDeleted($sickness);

    $action->execute($sickness);

    $this->assertSoftDeleted($sickness);
});
