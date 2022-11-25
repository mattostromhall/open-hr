<?php

use Domain\Recruitment\Actions\DeleteVacancyAction;
use Domain\Recruitment\Models\Vacancy;

it('deletes the vacancy', function () {
    $vacancy = Vacancy::factory()->create();

    $action = app(DeleteVacancyAction::class);

    $this->assertNotSoftDeleted($vacancy);

    $action->execute($vacancy);

    $this->assertSoftDeleted($vacancy);
});
