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

it('marks an application as successful', function () {
    $application = Application::factory()->create();

    $response = $this->post(route('application.successful', ['application' => $application]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Application marked as successful!');
});
