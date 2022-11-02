<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Enums\TrainingStatus;
use Domain\Performance\Models\Training;
use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Application;
use Domain\Recruitment\Models\Vacancy;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Faker\faker;

use Support\Enums\Currency;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('submits an application when the correct data is provided', function () {
    $vacancy = Vacancy::factory()->create();

    $response = $this->post(route('application.store'), [
        'vacancy_id' => $vacancy->id,
        'status' => ApplicationStatus::PENDING->value,
        'name' => faker()->name(),
        'contact_number' => faker()->phoneNumber(),
        'contact_email' => faker()->email(),
        'cv' => UploadedFile::fake()->create('document.pdf', 10)
    ]);

    $response
        ->assertStatus(302)
        ->assertRedirect(route('application.thanks'));
});

it('returns validation errors when submitting an application with incorrect data', function () {
    $response = $this->post(route('application.store'), [
        'vacancy_id' => null,
        'status' => null,
        'name' => null,
        'contact_number' => null,
        'contact_email' => null,
        'cv' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['vacancy_id', 'status', 'name', 'contact_number', 'contact_email', 'cv']);
});

it('shows the application', function () {
    $application = Application::factory()->create();

    $this->get(route('application.show', ['application' => $application]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Recruitment/Applications/Show')
                ->hasAll([
                    'application',
                    'status',
                    'vacancy',
                    'cv'
                ])
        );
});

it('returns the training to edit', function () {
    $training = Training::factory()->create();

    $this->get(route('training.edit', ['training' => $training]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/Training/Edit')
                ->hasAll([
                    'training',
                    'person',
                    'status',
                    'state'
                ])
        );
});

it('updates the training when the correct data is provided', function () {
    $training = Training::factory()->create();

    $response = $this->put(route('training.update', ['training' => $training]), [
        'status' => TrainingStatus::APPROVED->value,
        'state' => TrainingState::STARTED->value,
        'description' => faker()->text(),
        'provider' => faker()->company(),
        'cost' => 500,
        'cost_currency' => Currency::GBP->value
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Training updated!');
});

it('returns validation errors when updating the training with incorrect data', function () {
    $training = Training::factory()->create();

    $response = $this->put(route('training.update', ['training' => $training]), [
        'status' => null,
        'state' => null,
        'description' => null,
        'provider' => null,
        'cost' => 'not a number'
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['status', 'state', 'description', 'provider', 'cost', 'cost_currency']);
});
