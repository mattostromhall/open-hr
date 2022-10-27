<?php

use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use function Pest\Faker\faker;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->department = Department::factory()->create();
    $this->person = Person::factory()->for($this->department)->create();
    $this->actingAs($this->person->user);
});

it('returns the person index', function () {
    Person::factory()->for($this->department)->count(2)->create();

    $this->get(route('person.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('People/Person/Index')
                ->has('people', 4)
                ->hasAll([
                    'people.0.id',
                    'people.0.email',
                    'people.0.person.id',
                    'people.0.person.user_id',
                    'people.0.person.department_id',
                    'people.0.person.first_name',
                    'people.0.person.last_name',
                    'people.0.person.pronouns',
                    'people.0.person.position',
                    'people.0.person.department',
                    'people.1.id',
                    'people.1.email',
                    'people.1.person.id',
                    'people.1.person.user_id',
                    'people.1.person.department_id',
                    'people.1.person.first_name',
                    'people.1.person.last_name',
                    'people.1.person.pronouns',
                    'people.1.person.position',
                    'people.1.person.department',
                    'people.2.id',
                    'people.2.email',
                    'people.2.person.id',
                    'people.2.person.user_id',
                    'people.2.person.department_id',
                    'people.2.person.first_name',
                    'people.2.person.last_name',
                    'people.2.person.pronouns',
                    'people.2.person.position',
                    'people.2.person.department'
                ])
        );
});

it('returns the person create page', function () {
    $this->get(route('person.create'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('People/Person/Create')
                ->has('people', 2)
                ->hasAll([
                    'people.0.id',
                    'people.0.first_name',
                    'people.0.last_name',
                    'people.0.full_name',
                    'people.1.id',
                    'people.1.first_name',
                    'people.1.last_name',
                    'people.1.full_name'
                ])
                ->has('departments', 1)
        );
});

it('creates a new address when the correct data is provided', function () {
    $response = $this->post(route('address.store', ['person' => $this->person]), [
        'address_line' => faker()->streetAddress(),
        'country' => faker()->country(),
        'region' => faker()->text(10),
        'town_city' => faker()->city(),
        'postal_code' => faker()->postcode()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Address successfully created!');
});

it('returns validation errors when creating a new address with incorrect data', function () {
    $response = $this->post(route('address.store', ['person' => $this->person]), [
        'address_line' => null,
        'country' => null,
        'region' => null,
        'town_city' => null,
        'postal_code' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['address_line', 'country', 'region', 'town_city', 'postal_code']);
});

it('updates the address when the correct data is provided', function () {
    $address = Address::factory()->create();

    $response = $this->put(route('address.update', ['address' => $address]), [
        'address_line' => faker()->streetAddress(),
        'country' => faker()->country(),
        'region' => faker()->text(10),
        'town_city' => faker()->city(),
        'postal_code' => faker()->postcode()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Address successfully updated!');
});

it('returns validation errors when updating the address with incorrect data', function () {
    $address = Address::factory()->create();

    $response = $this->put(route('address.update', ['address' => $address]), [
        'address_line' => null,
        'country' => null,
        'region' => null,
        'town_city' => null,
        'postal_code' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['address_line', 'country', 'region', 'town_city', 'postal_code']);
});
