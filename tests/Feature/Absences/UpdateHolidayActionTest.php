<?php

use Domain\Absences\Actions\UpdateHolidayAction;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;

it('updates the holiday', function () {
    $holiday = Holiday::factory()->create();

    $action = app(UpdateHolidayAction::class);
    $holidayData = new HolidayData(
        person: $holiday->person,
        status: HolidayStatus::APPROVED,
        start_at: now(),
        finish_at: now()->addDay(),
        half_day: null,
        notes: null
    );

    $this->assertModelExists($holiday);

    $action->execute($holiday, $holidayData);

    $this->assertDatabaseHas('holidays', [
        'person_id' => $holidayData->person->id,
        'status' => HolidayStatus::APPROVED,
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDay()->toDateString(),
    ]);
});
