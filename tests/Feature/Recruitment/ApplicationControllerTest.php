<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
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
        'vacancy_public_id' => $vacancy->public_id,
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
        'vacancy_public_id' => null,
        'status' => null,
        'name' => null,
        'contact_number' => null,
        'contact_email' => null,
        'cv' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['vacancy_public_id', 'status', 'name', 'contact_number', 'contact_email', 'cv']);
});

it('shows the application', function () {
    $person = Person::factory()->create();
    $this->actingAs($person->user);
    $person->assign(Role::MANAGER);
    $vacancy = Vacancy::factory()->create([
        'contact_id' => $person->id
    ]);
    $application = Application::factory()->for($vacancy)->create();

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

it('returns unauthorized if the person does not have permission to view the application', function () {
    $person = Person::factory()->create();
    $this->actingAs($person->user);
    $application = Application::factory()->create();

    $this->get(route('application.show', ['application' => $application]))
        ->assertForbidden();
});

it('deletes the application', function () {
    $person = Person::factory()->create();
    $this->actingAs($person->user);
    $person->assign(Role::MANAGER);
    $vacancy = Vacancy::factory()->create([
        'contact_id' => $person->id
    ]);
    $application = Application::factory()->for($vacancy)->create();

    $response = $this->delete(route('application.destroy', ['application' => $application]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Application deleted!');
});

it('returns unauthorized if the person does not have permission to delete the application', function () {
    $person = Person::factory()->create();
    $this->actingAs($person->user);
    $application = Application::factory()->create();

    $response = $this->delete(route('application.destroy', ['application' => $application]));

    $response->assertForbidden();
});
