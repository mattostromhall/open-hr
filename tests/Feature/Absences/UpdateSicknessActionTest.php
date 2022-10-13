<?php

use Domain\Absences\Actions\UpdateSicknessAction;
use Domain\Absences\DataTransferObjects\SicknessData;
use Domain\Absences\Models\Sickness;

it('updates the sickness', function () {
    $sickness = Sickness::factory()->create();

    $action = app(UpdateSicknessAction::class);
    $sicknessData = new SicknessData(
        person: $sickness->person,
        start_at: now(),
        finish_at: now()->addDay()
    );

    $this->assertModelExists($sickness);

    $action->execute($sickness, $sicknessData);

    $this->assertDatabaseHas('sicknesses', [
        'person_id' => $sicknessData->person->id,
        'start_at' => now()->toDateString(),
        'finish_at' => now()->addDay()->toDateString()
    ]);
});
