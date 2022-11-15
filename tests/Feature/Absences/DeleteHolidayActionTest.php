<?php

use Domain\Absences\Actions\DeleteHolidayAction;
use Domain\Absences\Models\Holiday;

it('deletes the holiday', function () {
    $holiday = Holiday::factory()->create();

    $action = app(DeleteHolidayAction::class);

    $this->assertModelExists($holiday);

    $action->execute($holiday);

    $this->assertSoftDeleted($holiday);
});
