<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use function Pest\Faker\faker;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('creates a directory for the path provided', function () {
    $response = $this->post(route('directory.store'), [
        'path' => 'test/' . faker()->text(10)
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Folder successfully created!');
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
    $path = 'test/' . faker()->text(10);

    $createResponse = $this->post(route('directory.store'), [
        'path' => $path
    ]);

    $createResponse
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Folder successfully created!');

    $createResponse = $this->post(route('directory.destroy'), [
        'path' => $path
    ]);

    $createResponse
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Folder deleted!');
});
