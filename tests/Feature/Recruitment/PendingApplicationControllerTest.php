<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Application;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('marks an application as pending', function () {
    $application = Application::factory()->create([
        'status' => ApplicationStatus::SUCCESSFUL
    ]);

    $response = $this->post(route('application.pending', ['application' => $application]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Application marked as pending!');
});
