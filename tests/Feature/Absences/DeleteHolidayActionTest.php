<?php

use Domain\Absences\Actions\DeleteHolidayAction;
use Domain\Absences\Models\Holiday;

it('deletes the holiday', function () {
    $holiday = Holiday::factory()->create();

    $action = app(DeleteHolidayAction::class);

    $this->assertNotSoftDeleted($holiday);

    $action->execute($holiday);

    $this->assertSoftDeleted($holiday);
});
