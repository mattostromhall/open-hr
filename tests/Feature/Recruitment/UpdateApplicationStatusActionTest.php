<?php

use Domain\Recruitment\Actions\UpdateApplicationStatusAction;
use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Application;

it('updates an application status to successful', function () {
    $application = Application::factory()->create();

    $action = app(UpdateApplicationStatusAction::class);

    $this->assertModelExists($application);
    $this->assertNotEquals(ApplicationStatus::SUCCESSFUL, $application->status);

    $action->execute($application, ApplicationStatus::SUCCESSFUL);

    $this->assertDatabaseHas('applications', [
        'vacancy_id' => $application->vacancy_id,
        'status' => ApplicationStatus::SUCCESSFUL,
        'name' => $application->name,
        'contact_number' => $application->contact_number,
        'contact_email' => $application->contact_email,
        'cover_letter' => $application->cover_letter
    ]);
});

it('updates an application status to unsuccessful', function () {
    $application = Application::factory()->create();

    $action = app(UpdateApplicationStatusAction::class);

    $this->assertModelExists($application);
    $this->assertNotEquals(ApplicationStatus::UNSUCCESSFUL, $application->status);

    $action->execute($application, ApplicationStatus::UNSUCCESSFUL);

    $this->assertDatabaseHas('applications', [
        'vacancy_id' => $application->vacancy_id,
        'status' => ApplicationStatus::UNSUCCESSFUL,
        'name' => $application->name,
        'contact_number' => $application->contact_number,
        'contact_email' => $application->contact_email,
        'cover_letter' => $application->cover_letter
    ]);
});

it('updates an application status to pending', function () {
    $application = Application::factory()->create([
        'status' => ApplicationStatus::UNSUCCESSFUL
    ]);

    $action = app(UpdateApplicationStatusAction::class);

    $this->assertModelExists($application);
    $this->assertNotEquals(ApplicationStatus::PENDING, $application->status);

    $action->execute($application, ApplicationStatus::PENDING);

    $this->assertDatabaseHas('applications', [
        'vacancy_id' => $application->vacancy_id,
        'status' => ApplicationStatus::PENDING,
        'name' => $application->name,
        'contact_number' => $application->contact_number,
        'contact_email' => $application->contact_email,
        'cover_letter' => $application->cover_letter
    ]);
});
