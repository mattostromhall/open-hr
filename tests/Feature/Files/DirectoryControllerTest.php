<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use function Pest\Faker\fake;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('creates a directory for the path provided', function () {
    $this->person->assign(Role::ADMIN);

    $response = $this->post(route('directory.store'), [
        'path' => 'test/' . fake()->text(10)
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Folder successfully created!');
});

it('returns unauthorized if the person does not have permission to create directories', function () {
    $response = $this->post(route('directory.store'), [
        'path' => 'test/' . fake()->text(10)
    ]);

    $response->assertForbidden();
});

it('returns validation errors when submitting an expense with incorrect data', function () {
    $response = $this->post(route('directory.store'), [
        'path' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['path']);
});


it('deletes the directory at the path provided', function () {
    $this->person->assign(Role::ADMIN);
    $path = 'test/' . fake()->text(10);

    $createResponse = $this->post(route('directory.store'), [
        'path' => $path
    ]);

    $createResponse
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Folder successfully created!');

    $deleteResponse = $this->post(route('directory.destroy'), [
        'path' => $path
    ]);

    $deleteResponse
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Folder deleted!');
});

it('returns unauthorized if the person does not have permission to delete directories', function () {
    $this->person->assign(Role::ADMIN);
    $path = 'test/' . fake()->text(10);

    $createResponse = $this->post(route('directory.store'), [
        'path' => $path
    ]);

    $createResponse
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Folder successfully created!');

    $person = Person::factory()->create();
    $this->actingAs($person->user);

    $deleteResponse = $this->post(route('directory.destroy'), [
        'path' => $path
    ]);


    $deleteResponse->assertForbidden();
});
