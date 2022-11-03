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

it('shows the vacancy and application form', function () {
    $vacancy = Vacancy::factory()->create();

    $this->get(route('vacancy.application', ['vacancy' => $vacancy]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Recruitment/Vacancies/Apply')
                ->hasAll([
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
                    'contact.name',
                    'contact.email'
                ])
        );
});
