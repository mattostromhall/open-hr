<?php

use Domain\Absences\Actions\CreateSicknessAction;
use Domain\Absences\DataTransferObjects\SicknessData;
use Domain\People\Models\Person;

it('creates a sickness', function () {
    $person = Person::factory()->create();
    $action = app(CreateSicknessAction::class);
    $sicknessData = new SicknessData(
        person: $person,
        start_at: now(),
        finish_at: now()->addDay()
    );

    $action->execute($sicknessData);

    $this->assertDatabaseHas('sicknesses', [
        'person_id' => $sicknessData->person->id,
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDay()->toDateString(),
        'notes' => null
    ]);
});
