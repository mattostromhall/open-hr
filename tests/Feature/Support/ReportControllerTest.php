<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Faker\faker;

use Support\Models\Report;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the report index', function () {
    $this->person->user->assign(Role::ADMIN->value);
    Report::factory()->count(3)->create();

    $this->get(route('report.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Reports/Index')
                ->has('reports.data', 3)
                ->hasAll([
                    'reports.data.0.id',
                    'reports.data.0.label',
                    'reports.data.0.last_ran',
                    'reports.data.1.id',
                    'reports.data.1.label',
                    'reports.data.1.last_ran',
                    'reports.data.2.id',
                    'reports.data.2.label',
                    'reports.data.2.last_ran'
                ])
        );
});

it('returns unauthorized if the person does not have permission to view the report index', function () {
    Report::factory()->count(3)->create();

    $this->get(route('report.index'))
        ->assertForbidden();
});

it('returns the report create page', function () {
    $this->person->user->assign(Role::ADMIN->value);

    $this->get(route('report.create'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Reports/Create')
                ->hasAll([
                    'report',
                    'models',
                    'reportableColumns'
                ])
        );
});

it('returns unauthorized when creating if the person does not have permission to create a report', function () {
    $this->get(route('report.create'))
        ->assertForbidden();
});

it('creates a report when the correct data is provided', function () {
    $this->person->user->assign(Role::ADMIN->value);

    $response = $this->post(route('report.store'), [
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
        ->assertSessionHas('flash.success', 'Report successfully saved!');
});

it('returns unauthorized if the person does not have permission to create a report', function () {
    $response = $this->post(route('report.store'), [
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

it('returns validation errors when creating a report with incorrect data', function () {
    $response = $this->post(route('report.store'), [
        'label' => faker()->word(),
        'model' => '',
        'condition_sets' => []
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['model', 'condition_sets']);
});

it('returns the report to edit', function () {
    $this->person->user->assign(Role::ADMIN->value);
    $report = Report::factory()->create();

    $this->get(route('report.edit', ['report' => $report]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Reports/Edit')
                ->hasAll([
                    'report',
                    'models',
                    'reportableColumns'
                ])
        );
});

it('returns unauthorized when editing if the person does not have permission to update the report', function () {
    $report = Report::factory()->create();

    $this->get(route('report.edit', ['report' => $report]))
        ->assertForbidden();
});

it('updates the report when the correct data is provided', function () {
    $this->person->user->assign(Role::ADMIN->value);
    $report = Report::factory()->create();

    $response = $this->put(route('report.update', ['report' => $report]), [
        'label' => faker()->word(),
        'model' => 'objective',
        'condition_sets' => [
            [
                'type' => 'and',
                'conditions' => [
                    [
                        'column' => 'title',
                        'operator' => '=',
                        'value' => 'Test Updated'
                    ]
                ]
            ]
        ]
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Report updated!');
});

it('returns unauthorized if the person does not have permission to update the report', function () {
    $report = Report::factory()->create();

    $response = $this->put(route('report.update', ['report' => $report]), [
        'label' => faker()->word(),
        'model' => 'objective',
        'condition_sets' => [
            [
                'type' => 'and',
                'conditions' => [
                    [
                        'column' => 'title',
                        'operator' => '=',
                        'value' => 'Test Updated'
                    ]
                ]
            ]
        ]
    ]);

    $response->assertForbidden();
});

it('returns validation errors when updating the report with incorrect data', function () {
    $report = Report::factory()->create();

    $response = $this->put(route('report.update', ['report' => $report]), [
        'label' => faker()->word(),
        'model' => '',
        'condition_sets' => []
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['model', 'condition_sets']);
});

it('deletes the report', function () {
    $this->person->user->assign(Role::ADMIN->value);
    $report = Report::factory()->create();

    $response = $this->delete(route('report.destroy', ['report' => $report]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Report deleted!');
});

it('returns unauthorized if the person does not have permission to delete the report', function () {
    $report = Report::factory()->create();

    $response = $this->delete(route('report.destroy', ['report' => $report]));

    $response->assertForbidden();
});
