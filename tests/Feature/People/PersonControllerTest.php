<?php

use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Support\Enums\Currency;
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

it('creates a new user and person when the correct data is provided', function () {
    $password = faker()->password(8);
    $response = $this->post(route('person.store'), [
        // User
        'email' => faker()->companyEmail(),
        'password' => $password,
        'password_confirmation' => $password,
        // Person
        'first_name' => faker()->firstName(),
        'last_name' => faker()->lastName(),
        'dob' => now()->subYears(30),
        'position' => faker()->jobTitle(),
        'remuneration' => faker()->numberBetween(10000, 100000),
        'remuneration_interval' => RemunerationInterval::YEARLY->value,
        'remuneration_currency' => Currency::GBP->value,
        'base_holiday_allocation' => 25,
        'sickness_allocation' => 10,
        'contact_number' => faker()->phoneNumber(),
        'contact_email' => faker()->email(),
        'started_on' => now()->subYear()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Person successfully created!');
});

it('returns validation errors when creating a new user and person with incorrect data', function () {
    $response = $this->post(route('person.store'), [
        // User
        'email' => null,
        'password' => null,
        'password_confirmation' => null,
        // Person
        'first_name' => null,
        'last_name' => null,
        'dob' => null,
        'position' => null,
        'remuneration' => null,
        'remuneration_interval' => null,
        'remuneration_currency' => null,
        'base_holiday_allocation' => null,
        'sickness_allocation' => null,
        'contact_number' => null,
        'contact_email' => null,
        'started_on' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['email', 'password', 'first_name', 'last_name', 'dob', 'position', 'remuneration', 'remuneration_interval', 'remuneration_currency', 'base_holiday_allocation', 'sickness_allocation', 'contact_number', 'contact_email', 'started_on']);
});

it('shows the person', function () {
    $this->get(route('person.show', ['person' => $this->person]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('People/Person/Show')
                ->hasAll([
                    'person',
                    'user',
                    'people',
                    'departments',
                    'address',
                    'directReports',
                    'roles',
                    'allRoles'
                ])
        );
});

it('returns the person to edit', function () {
    $this->get(route('person.edit', ['person' => $this->person]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('People/Person/Edit')
                ->hasAll([
                    'person',
                    'user',
                    'people',
                    'departments',
                    'address',
                    'directReports',
                    'roles',
                    'allRoles'
                ])
        );
});

it('updates the person when the correct data is provided', function () {
    $response = $this->put(route('person.update', ['person' => $this->person]), [
        'user_id' => $this->person->user->id,
        'first_name' => faker()->firstName(),
        'last_name' => faker()->lastName(),
        'dob' => now()->subYears(30),
        'position' => faker()->jobTitle(),
        'remuneration' => faker()->numberBetween(10000, 100000),
        'remuneration_interval' => RemunerationInterval::YEARLY->value,
        'remuneration_currency' => Currency::GBP->value,
        'base_holiday_allocation' => 25,
        'sickness_allocation' => 10,
        'contact_number' => faker()->phoneNumber(),
        'contact_email' => faker()->email(),
        'started_on' => now()->subYear(),
        'hex_code' => '#000000'
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Person successfully updated!');
});

it('returns validation errors when updating the person with incorrect data', function () {
    $response = $this->put(route('person.update', ['person' => $this->person]), [
        'user_id' => null,
        'first_name' => null,
        'last_name' => null,
        'dob' => null,
        'position' => null,
        'remuneration' => null,
        'remuneration_interval' => null,
        'remuneration_currency' => null,
        'base_holiday_allocation' => null,
        'sickness_allocation' => null,
        'contact_number' => null,
        'contact_email' => null,
        'started_on' => null,
        'hex_code' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['user_id', 'first_name', 'last_name', 'dob', 'position', 'remuneration', 'remuneration_interval', 'remuneration_currency', 'base_holiday_allocation', 'sickness_allocation', 'contact_number', 'contact_email', 'started_on', 'hex_code']);
});
