<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('manages the direct reports for the person', function () {
    $this->person->user->assign(Role::MANAGER->value);
    $people = Person::factory()->count(3)->create();

    $response = $this->post(route('person.direct-reports', ['person' => $this->person]), [
        'direct_reports' => $people->pluck('id')->toArray()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success',  'Direct reports updated!');
});

it('returns unauthorized if the person does not have permission to manage direct reports', function () {
    $people = Person::factory()->count(3)->create();

    $response = $this->post(route('person.direct-reports', ['person' => $this->person]), [
        'direct_reports' => $people->pluck('id')->toArray()
    ]);

    $response->assertForbidden();
});

it('returns validation errors when managing the direct reports for the person with incorrect data', function () {
    $response = $this->post(route('person.direct-reports', ['person' => $this->person]), [
        'direct_reports' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['direct_reports']);
});
