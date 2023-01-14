<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('bulk deletes the selected people', function () {
    $this->person->assign(Role::ADMIN);
    $people = Person::factory()->count(3)->create();

    $response = $this->post(route('person.bulk-delete'), [
        'people' => $people->pluck('id')->toArray()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success',  'Selected People deleted!');
});

it('returns unauthorized if the person does not have permission to bulk delete people', function () {
    $people = Person::factory()->count(3)->create();

    $response = $this->post(route('person.bulk-delete'), [
        'people' => $people->pluck('id')->toArray()
    ]);

    $response->assertForbidden();
});

it('returns validation errors when managing the direct reports for the person with incorrect data', function () {
    $response = $this->post(route('person.bulk-delete'), [
        'people' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['people']);
});
