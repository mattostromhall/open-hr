<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ContractType;
use Domain\Recruitment\Models\Application;
use Domain\Recruitment\Models\Vacancy;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Faker\fake;

use Support\Enums\Currency;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the vacancies index', function () {
    $this->person->assign(Role::HEAD_OF_DEPARTMENT);
    Vacancy::factory()->count(3)->create();
    Vacancy::factory()->count(3)->create([
        'close_at' => now()->subDay()
    ]);

    $this->get(route('vacancy.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Recruitment/Vacancies/Index')
                ->where('active', 'post')
                ->hasAll([
                    'contacts',
                    'contractTypes',
                    'open' => 3,
                    'closed' => 3
                ])
        );
});

it('returns unauthorized if the person does not have permission to view vacancies', function () {
    Vacancy::factory()->count(3)->create();
    Vacancy::factory()->count(3)->create([
        'close_at' => now()->subDay()
    ]);

    $this->get(route('vacancy.index'))
        ->assertForbidden();
});

it('posts a vacancy when the correct data is provided', function () {
    $this->person->assign(Role::HEAD_OF_DEPARTMENT);

    $response = $this->post(route('vacancy.store'), [
        'contact_id' => $this->person->id,
        'title' => fake()->text(),
        'description' => fake()->randomHtml(),
        'location' => 'remote',
        'contract_type' => ContractType::FULL_TIME->value,
        'remuneration' => 70000,
        'remuneration_currency' => Currency::GBP->value,
        'open_at' => now(),
        'close_at' => now()->addDays(90)
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Vacancy posted!');
});

it('returns unauthorized if the person does not have permission to create a vacancy', function () {
    $response = $this->post(route('vacancy.store'), [
        'contact_id' => $this->person->id,
        'title' => fake()->text(),
        'description' => fake()->randomHtml(),
        'location' => 'remote',
        'contract_type' => ContractType::FULL_TIME->value,
        'remuneration' => 70000,
        'remuneration_currency' => Currency::GBP->value,
        'open_at' => now(),
        'close_at' => now()->addDays(90)
    ]);

    $response->assertForbidden();
});

it('returns validation errors when posting a vacancy with incorrect data', function () {
    $response = $this->post(route('vacancy.store'), [
        'contact_id' => null,
        'title' => null,
        'description' => null,
        'contract_type' => 'not a type',
        'open_at' => 'not a date',
        'close_at' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['contact_id', 'title', 'description', 'contract_type', 'open_at', 'close_at']);
});

it('shows the vacancy', function () {
    $this->person->assign(Role::MANAGER);
    $vacancy = Vacancy::factory()->create([
        'contact_id' => $this->person->id
    ]);
    Application::factory()->for($vacancy)->count(3)->create();

    $this->get(route('vacancy.show', ['vacancy' => $vacancy]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Recruitment/Vacancies/Show')
                ->where('active', 'overview')
                ->hasAll([
                    'vacancy.id',
                    'vacancy.contact_id',
                    'vacancy.public_id',
                    'vacancy.title',
                    'vacancy.description',
                    'vacancy.location',
                    'vacancy.contract_type',
                    'vacancy.contract_length',
                    'vacancy.remuneration',
                    'vacancy.remuneration_currency',
                    'vacancy.open_at',
                    'vacancy.close_at',
                    'contact.id',
                    'contact.full_name',
                    'applications.data' => 3
                ])
        );
});

it('returns unauthorized if the person does not have permission to view the vacancy', function () {
    $vacancy = Vacancy::factory()->create();
    Application::factory()->for($vacancy)->count(3)->create();

    $this->get(route('vacancy.show', ['vacancy' => $vacancy]))
        ->assertForbidden();
});

it('returns the vacancy to edit', function () {
    $this->person->assign(Role::MANAGER);
    $vacancy = Vacancy::factory()->create([
        'contact_id' => $this->person->id
    ]);

    $this->get(route('vacancy.edit', ['vacancy' => $vacancy]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Recruitment/Vacancies/Edit')
                ->hasAll([
                    'vacancy.id',
                    'vacancy.contact_id',
                    'vacancy.public_id',
                    'vacancy.title',
                    'vacancy.description',
                    'vacancy.location',
                    'vacancy.contract_type',
                    'vacancy.contract_length',
                    'vacancy.remuneration',
                    'vacancy.remuneration_currency',
                    'vacancy.open_at',
                    'vacancy.close_at',
                    'contacts',
                    'contractTypes'
                ])
        );
});

it('returns unauthorized when editing if the person does not have permission to update the vacancy', function () {
    $vacancy = Vacancy::factory()->create();

    $this->get(route('vacancy.edit', ['vacancy' => $vacancy]))
        ->assertForbidden();
});

it('updates the vacancy when the correct data is provided', function () {
    $this->person->assign(Role::MANAGER);
    $vacancy = Vacancy::factory()->create([
        'contact_id' => $this->person->id
    ]);

    $response = $this->put(route('vacancy.update', ['vacancy' => $vacancy]), [
        'contact_id' => $this->person->id,
        'title' => fake()->text(),
        'description' => fake()->randomHtml(),
        'location' => 'remote',
        'contract_type' => ContractType::FULL_TIME->value,
        'remuneration' => 70000,
        'remuneration_currency' => Currency::GBP->value,
        'open_at' => now(),
        'close_at' => now()->addDays(90)
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Vacancy updated!');
});

it('returns unauthorized if the person does not have permission to update the vacancy', function () {
    $vacancy = Vacancy::factory()->create();

    $response = $this->put(route('vacancy.update', ['vacancy' => $vacancy]), [
        'contact_id' => $this->person->id,
        'title' => fake()->text(),
        'description' => fake()->randomHtml(),
        'location' => 'remote',
        'contract_type' => ContractType::FULL_TIME->value,
        'remuneration' => 70000,
        'remuneration_currency' => Currency::GBP->value,
        'open_at' => now(),
        'close_at' => now()->addDays(90)
    ]);

    $response->assertForbidden();
});

it('returns validation errors when updating a vacancy with incorrect data', function () {
    $vacancy = Vacancy::factory()->create();

    $response = $this->put(route('vacancy.update', ['vacancy' => $vacancy]), [
        'contact_id' => null,
        'title' => null,
        'description' => null,
        'contract_type' => 'not a type',
        'open_at' => 'not a date',
        'close_at' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['contact_id', 'title', 'description', 'contract_type', 'open_at', 'close_at']);
});

it('deletes the vacancy', function () {
    $this->person->assign(Role::MANAGER);
    $vacancy = Vacancy::factory()->create([
        'contact_id' => $this->person->id
    ]);

    $response = $this->delete(route('vacancy.destroy', ['vacancy' => $vacancy]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Vacancy deleted!');
});

it('returns unauthorized if the person does not have permission to delete the vacancy', function () {
    $vacancy = Vacancy::factory()->create();

    $response = $this->delete(route('vacancy.destroy', ['vacancy' => $vacancy]));

    $response->assertForbidden();
});
