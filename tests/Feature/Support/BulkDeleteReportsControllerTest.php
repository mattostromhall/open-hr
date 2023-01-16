<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Support\Models\Report;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('bulk deletes the selected reports', function () {
    $this->person->assign(Role::ADMIN);
    $reports = Report::factory()->count(3)->create();

    $response = $this->post(route('report.bulk-delete'), [
        'reports' => $reports->pluck('id')->toArray()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success',  'Selected Reports deleted!');
});

it('returns unauthorized if the person does not have permission to bulk delete reports', function () {
    $reports = Report::factory()->count(3)->create();

    $response = $this->post(route('report.bulk-delete'), [
        'reports' => $reports->pluck('id')->toArray()
    ]);

    $response->assertForbidden();
});
