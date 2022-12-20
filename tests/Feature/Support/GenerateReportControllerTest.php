<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Faker\faker;

use Support\Models\Report;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('generates a report when the correct data is provided', function () {
    $this->person->user->assign(Role::ADMIN->value);

    $response = $this->post(route('report.generate.store'), [
        'label' => faker()->word(),
        'model' => 'objective',
        'condition_sets' => [
            [
                'type' => 'and',
                'conditions' => [
                    [
                    'column' => 'title',
                    'operator' => '=',
                    'value' => 'Test'
                    ]
                ]
            ]
        ]
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Report successfully generated! Click the button below to download.')
        ->assertSessionHas('csv.path');
});

it('returns unauthorized if the person does not have permission to generate a report', function () {
    $response = $this->post(route('report.generate.store'), [
        'label' => faker()->word(),
        'model' => 'objective',
        'condition_sets' => [
            [
                'type' => 'and',
                'conditions' => [
                    [
                        'column' => 'title',
                        'operator' => '=',
                        'value' => 'Test'
                    ]
                ]
            ]
        ]
    ]);

    $response->assertForbidden();
});

it('returns validation errors when generating a report with incorrect data', function () {
    $response = $this->post(route('report.generate.store'), [
        'label' => faker()->word(),
        'model' => '',
        'condition_sets' => []
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['model', 'condition_sets']);
});

it('downloads the report', function () {
    $this->person->user->assign(Role::ADMIN->value);

    $this->post(route('report.generate.store'), [
        'label' => 'test-report',
        'model' => 'objective',
        'condition_sets' => [
            [
                'type' => 'and',
                'conditions' => [
                    [
                        'column' => 'title',
                        'operator' => '=',
                        'value' => 'Test'
                    ]
                ]
            ]
        ]
    ]);

    $response = $this->get(
        route('report.generate.show', ['path' => 'reports/test-report.csv'])
    );

    $response->assertStatus(200);
});

it('returns unauthorized if the person does not have permission to download the report', function () {
    $this->get(route('report.generate.show', ['path' => 'reports/test.csv']))
        ->assertForbidden();
});

afterEach(function () {
    Storage::deleteDirectory('reports');
});
