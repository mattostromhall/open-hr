<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Recruitment\Models\Application;
use Domain\Recruitment\Models\Vacancy;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('marks an application as unsuccessful', function () {
    $this->person->user->assign(Role::MANAGER->value);
    $vacancy = Vacancy::factory()->create([
        'contact_id' => $this->person->id
    ]);
    $application = Application::factory()->for($vacancy)->create();

    $response = $this->post(route('application.unsuccessful', ['application' => $application]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Application marked as unsuccessful!');
});

it('returns unauthorized if the person does not have permission mark the application as unsuccessful', function () {
    $application = Application::factory()->create();

    $response = $this->post(route('application.unsuccessful', ['application' => $application]));

    $response->assertForbidden();
});
