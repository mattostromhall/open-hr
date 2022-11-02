<?php

use Domain\Organisation\Models\Organisation;
use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Application;
use Domain\Recruitment\Models\Vacancy;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Faker\faker;

beforeEach(function () {
    Organisation::factory()->create();
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
