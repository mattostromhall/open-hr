<?php

use Domain\Absences\Actions\UpdateHolidayAction;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;
use Domain\People\Models\Person;

it('updates the holiday', function () {
    $person = Person::factory()->create();
    $holiday = Holiday::factory()
        ->for($person)
        ->create();

    $action = app(UpdateHolidayAction::class);
    $holidayData = new HolidayData(
        person: $person,
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
