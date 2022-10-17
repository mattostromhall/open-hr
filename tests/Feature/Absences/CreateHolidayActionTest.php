<?php

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Enums\HalfDay;
use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Actions\CreateHolidayAction;
use Domain\People\Models\Person;

it('creates a holiday request for the dates provided', function () {
    $person = Person::factory()->create();
    $action = app(CreateHolidayAction::class);
    $holidayData = new HolidayData(
        person: $person,
        status: HolidayStatus::PENDING,
        start_at: now(),
        finish_at: now()->addDay(),
        half_day: null,
        notes: null
    );

    $action->execute($holidayData);

    $this->assertDatabaseHas('holidays', [
        'person_id' => $holidayData->person->id,
        'status' => HolidayStatus::PENDING,
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDay()->toDateString(),
    ]);
});

it('creates a half day holiday request', function () {
    $person = Person::factory()->create();
    $action = app(CreateHolidayAction::class);
    $holidayData = new HolidayData(
        person: $person,
        status: HolidayStatus::PENDING,
        start_at: now(),
        finish_at: now(),
        half_day: HalfDay::AM,
        notes: 'Here are some notes'
    );

    $action->execute($holidayData);

    $this->assertDatabaseHas('holidays', [
        'person_id' => $holidayData->person->id,
        'status' => HolidayStatus::PENDING,
        'start_at' => now()->toDateString(),
        'finish_at' => now()->toDateString(),
        'half_day' => 'am',
        'notes' => 'Here are some notes'
    ]);
});
