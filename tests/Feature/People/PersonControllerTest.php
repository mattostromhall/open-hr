<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Faker\fake;

use Support\Enums\Currency;

beforeEach(function () {
    Organisation::factory()->create();
    $this->department = Department::factory()->create();
    $this->person = Person::factory()->for($this->department)->create();
    $this->actingAs($this->person->user);
});

it('returns the person index', function () {
    $this->person->assign(Role::ADMIN);
    Person::factory()->for($this->department)->count(2)->create();

    $this->get(route('person.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('People/Person/Index')
                ->has('people.data', 4)
                ->hasAll([
                    'people.data.0.id',
                    'people.data.0.email',
                    'people.data.0.person.id',
                    'people.data.0.person.user_id',
                    'people.data.0.person.department_id',
                    'people.data.0.person.first_name',
                    'people.data.0.person.last_name',
                    'people.data.0.person.pronouns',
                    'people.data.0.person.position',
                    'people.data.0.person.department',
                    'people.data.1.id',
                    'people.data.1.email',
                    'people.data.1.person.id',
                    'people.data.1.person.user_id',
                    'people.data.1.person.department_id',
                    'people.data.1.person.first_name',
                    'people.data.1.person.last_name',
                    'people.data.1.person.pronouns',
                    'people.data.1.person.position',
                    'people.data.1.person.department',
                    'people.data.2.id',
                    'people.data.2.email',
                    'people.data.2.person.id',
                    'people.data.2.person.user_id',
                    'people.data.2.person.department_id',
                    'people.data.2.person.first_name',
                    'people.data.2.person.last_name',
                    'people.data.2.person.pronouns',
                    'people.data.2.person.position',
                    'people.data.2.person.department'
                ])
        );
});

it('returns unauthorized if the person does not have permission to view people', function () {
    Person::factory()->for($this->department)->count(2)->create();

    $this->get(route('person.index'))
        ->assertForbidden();
});

it('returns the person create page', function () {
    $this->person->assign(Role::MANAGER);

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

it('returns unauthorized when creating if the person does not have permission to create a person', function () {
    $this->get(route('person.create'))
        ->assertForbidden();
});

it('creates a new user and person when the correct data is provided', function () {
    $this->person->assign(Role::HEAD_OF_DEPARTMENT);
    $password = fake()->password(8);

    $response = $this->post(route('person.store'), [
        // User
        'email' => fake()->companyEmail(),
        'password' => $password,
        'password_confirmation' => $password,
        // Person
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'dob' => now()->subYears(30),
        'position' => fake()->jobTitle(),
        'remuneration' => fake()->numberBetween(10000, 100000),
        'remuneration_interval' => RemunerationInterval::YEARLY->value,
        'remuneration_currency' => Currency::GBP->value,
        'base_holiday_allocation' => 25,
        'sickness_allocation' => 10,
        'contact_number' => fake()->phoneNumber(),
        'contact_email' => fake()->email(),
        'started_on' => now()->subYear()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Person successfully created!');
});

it('returns unauthorized if the person does not have permission to create a person', function () {
    $password = fake()->password(8);

    $response = $this->post(route('person.store'), [
        // User
        'email' => fake()->companyEmail(),
        'password' => $password,
        'password_confirmation' => $password,
        // Person
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'dob' => now()->subYears(30),
        'position' => fake()->jobTitle(),
        'remuneration' => fake()->numberBetween(10000, 100000),
        'remuneration_interval' => RemunerationInterval::YEARLY->value,
        'remuneration_currency' => Currency::GBP->value,
        'base_holiday_allocation' => 25,
        'sickness_allocation' => 10,
        'contact_number' => fake()->phoneNumber(),
        'contact_email' => fake()->email(),
        'started_on' => now()->subYear()
    ]);

    $response->assertForbidden();
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
    $this->person->assign(Role::PERSON);

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

it('returns unauthorized if the person does not have permission to view the person', function () {
    $this->get(route('person.show', ['person' => $this->person]))
        ->assertForbidden();
});

it('returns the person to edit', function () {
    $this->person->assign(Role::PERSON);

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

it('returns unauthorized when editing if the person does not have permission to update the person', function () {
    $this->get(route('person.edit', ['person' => $this->person]))
        ->assertForbidden();
});

it('updates the person when the correct data is provided', function () {
    $this->person->assign(Role::MANAGER);

    $response = $this->put(route('person.update', ['person' => $this->person]), [
        'user_id' => $this->person->user->id,
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'dob' => now()->subYears(30),
        'position' => fake()->jobTitle(),
        'remuneration' => fake()->numberBetween(10000, 100000),
        'remuneration_interval' => RemunerationInterval::YEARLY->value,
        'remuneration_currency' => Currency::GBP->value,
        'base_holiday_allocation' => 25,
        'sickness_allocation' => 10,
        'contact_number' => fake()->phoneNumber(),
        'contact_email' => fake()->email(),
        'started_on' => now()->subYear(),
        'hex_code' => '#000000'
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Person successfully updated!');
});

it('returns unauthorized if the person does not have permission to update the person', function () {
    $response = $this->put(route('person.update', ['person' => $this->person]), [
        'user_id' => $this->person->user->id,
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'dob' => now()->subYears(30),
        'position' => fake()->jobTitle(),
        'remuneration' => fake()->numberBetween(10000, 100000),
        'remuneration_interval' => RemunerationInterval::YEARLY->value,
        'remuneration_currency' => Currency::GBP->value,
        'base_holiday_allocation' => 25,
        'sickness_allocation' => 10,
        'contact_number' => fake()->phoneNumber(),
        'contact_email' => fake()->email(),
        'started_on' => now()->subYear(),
        'hex_code' => '#000000'
    ]);

    $response->assertForbidden();
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

it('deletes the person', function () {
    $this->person->assign(Role::ADMIN);

    $response = $this->delete(route('person.destroy', ['person' => $this->person]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Person deleted!');
});

it('returns unauthorized if the person does not have permission to delete the person', function () {
    $response = $this->delete(route('person.destroy', ['person' => $this->person]));

    $response->assertForbidden();
});
