<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Application;
use Domain\Recruitment\Models\Vacancy;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('marks an application as pending', function () {
    $this->person->assign(Role::MANAGER);
    $vacancy = Vacancy::factory()->create([
        'contact_id' => $this->person->id
    ]);
    $application = Application::factory()
        ->for($vacancy)
        ->create([
            'status' => ApplicationStatus::SUCCESSFUL
        ]);

    $response = $this->post(route('application.pending', ['application' => $application]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Application marked as pending!');
});

it('returns unauthorized if the person does not have permission to mark the application as pending', function () {
    $application = Application::factory()->create([
            'status' => ApplicationStatus::SUCCESSFUL
        ]);

    $response = $this->post(route('application.pending', ['application' => $application]));

    $response->assertForbidden();
});
