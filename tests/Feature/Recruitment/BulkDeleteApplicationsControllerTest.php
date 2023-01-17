<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Recruitment\Models\Application;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('bulk deletes the selected applications', function () {
    $this->person->assign(Role::ADMIN);
    $applications = Application::factory()->count(3)->create();

    $response = $this->post(route('application.bulk-delete'), [
        'applications' => $applications->pluck('id')->toArray()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success',  'Selected Applications deleted!');
});

it('returns unauthorized if the person does not have permission to bulk delete applications', function () {
    $applications = Application::factory()->count(3)->create();

    $response = $this->post(route('application.bulk-delete'), [
        'applications' => $applications->pluck('id')->toArray()
    ]);

    $response->assertForbidden();
});
