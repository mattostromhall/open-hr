<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Models\Objective;
use Inertia\Testing\AssertableInertia as Assert;
use Support\Models\ActionLog;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the action log index', function () {
    $this->person->assign(Role::ADMIN);

    $this->get(route('logs.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page->component('ActionLogs/Index')
        );
});

it('returns unauthorized if the person does not have permission view the action log index', function () {
    $this->get(route('logs.index'))
        ->assertForbidden();
});

it('shows the action log for the resource', function () {
    $this->person->assign(Role::ADMIN);
    $objective = Objective::factory()->create();
    ActionLog::factory()->create([
        'payload' => json_encode($objective->getAttributes()),
        'actionable_id' => $objective->id
    ]);

    $this->get(route('logs.show', [
        'type' => 'objective',
        'id' => $objective->id
    ]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('ActionLogs/Show')
                ->has('actionLogs')
        );
});

it('returns unauthorized if the person does not have permission view the action log', function () {
    $objective = Objective::factory()->create();
    ActionLog::factory()->create([
        'payload' => json_encode($objective->getAttributes()),
        'actionable_id' => $objective->id
    ]);

    $this->get(route('logs.show', [
        'type' => 'objective',
        'id' => $objective->id
    ]))
        ->assertForbidden();
});
