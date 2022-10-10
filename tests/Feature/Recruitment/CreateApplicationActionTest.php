<?php

use Domain\Recruitment\Actions\CreateApplicationAction;
use Domain\Recruitment\DataTransferObjects\ApplicationData;
use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Vacancy;
use function Pest\Faker\faker;

it('creates an application', function () {
    $vacancy = Vacancy::factory()->create();

    $action = app(CreateApplicationAction::class);
    $applicationData = new ApplicationData(
        vacancy: $vacancy,
        status: ApplicationStatus::PENDING,
        name: faker()->name(),
        contact_number: faker()->phoneNumber(),
        contact_email: faker()->email(),
        cover_letter: faker()->randomHtml()
    );

    $action->execute($applicationData);

    $this->assertDatabaseHas('applications', [
        'vacancy_id' => $applicationData->vacancy->id,
        'status' => $applicationData->status,
        'name' => $applicationData->name,
        'contact_number' => $applicationData->contact_number,
        'contact_email' => $applicationData->contact_email,
        'cover_letter' => $applicationData->cover_letter
    ]);
});
