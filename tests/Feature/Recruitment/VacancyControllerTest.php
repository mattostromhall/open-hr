<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ContractType;
use Domain\Recruitment\Models\Application;
use Domain\Recruitment\Models\Vacancy;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Faker\faker;

use Support\Enums\Currency;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the vacancies index', function () {
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

it('posts a vacancy when the correct data is provided', function () {
    $response = $this->post(route('vacancy.store'), [
        'contact_id' => $this->person->id,
        'title' => faker()->text(),
        'description' => faker()->randomHtml(),
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
    $vacancy = Vacancy::factory()->create();
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
                    'applications' => 3
                ])
        );
});

it('returns the vacancy to edit', function () {
    $vacancy = Vacancy::factory()->create();

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

it('updates the vacancy when the correct data is provided', function () {
    $vacancy = Vacancy::factory()->create();

    $response = $this->put(route('vacancy.update', ['vacancy' => $vacancy]), [
        'contact_id' => $this->person->id,
        'title' => faker()->text(),
        'description' => faker()->randomHtml(),
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
