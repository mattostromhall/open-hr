<?php

use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Faker\faker;

beforeEach(function () {
    Organisation::factory()->create();
    $this->department = Department::factory()->create();
    $this->person = Person::factory()->for($this->department)->create();
    $this->actingAs($this->person->user);
});

it('returns the profile to edit', function () {
    $this->get(route('person.profile', ['person' => $this->person]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('People/Profile/Index')
                ->hasAll([
                    'user.id',
                    'user.email',
                    'person.id',
                    'person.full_name',
                    'person.title',
                    'person.first_name',
                    'person.last_name',
                    'person.initials',
                    'person.pronouns',
                    'person.dob',
                    'person.contact_number',
                    'person.contact_email',
                    'address'
                ])
        );
});

it('updates the profile when the correct data is provided', function () {
    $response = $this->patch(route('profile.update', ['person' => $this->person]), [
        'first_name' => faker()->firstName(),
        'last_name' => faker()->lastName(),
        'dob' => now()->subYears(30),
        'contact_number' => faker()->phoneNumber(),
        'contact_email' => faker()->email(),
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Personal Information successfully updated!');
});

it('returns validation errors when updating the profile with incorrect data', function () {
    $response = $this->patch(route('profile.update', ['person' => $this->person]), [
        'first_name' => null,
        'last_name' => null,
        'dob' => null,
        'contact_number' => null,
        'contact_email' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['first_name', 'last_name', 'dob', 'contact_number', 'contact_email']);
});
