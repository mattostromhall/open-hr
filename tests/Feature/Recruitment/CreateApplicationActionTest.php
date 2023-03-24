<?php

use Domain\Recruitment\Actions\CreateApplicationAction;
use Domain\Recruitment\DataTransferObjects\ApplicationData;
use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Vacancy;
use Support\Actions\StripScriptTagsAction;
use function Pest\Faker\fake;

it('creates an application', function () {
    $vacancy = Vacancy::factory()->create();

    $action = app(CreateApplicationAction::class);
    $applicationData = new ApplicationData(
        vacancy: $vacancy,
        status: ApplicationStatus::PENDING,
        name: fake()->name(),
        contact_number: fake()->phoneNumber(),
        contact_email: fake()->email(),
        cover_letter: fake()->randomHtml()
    );

    $action->execute($applicationData);

    $this->assertDatabaseHas('applications', [
        'vacancy_id' => $applicationData->vacancy->id,
        'status' => $applicationData->status,
        'name' => $applicationData->name,
        'contact_number' => $applicationData->contact_number,
        'contact_email' => $applicationData->contact_email,
        'cover_letter' => app(StripScriptTagsAction::class)->execute($applicationData->cover_letter),
    ]);
});
