<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Enums\TrainingStatus;
use Domain\Performance\Models\Training;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the training management index', function () {
    $this->person->assign(Role::MANAGER);
    $directReport = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);

    Training::factory()->for($directReport)->count(3)->create();
    Training::factory()->for($directReport)->count(3)->create([
        'status' => TrainingStatus::APPROVED
    ]);
    Training::factory()->for($directReport)->count(3)->create([
        'status' => TrainingStatus::APPROVED,
        'state' => TrainingState::STARTED
    ]);
    Training::factory()->for($directReport)->count(3)->create([
        'status' => TrainingStatus::APPROVED,
        'state' => TrainingState::COMPLETED
    ]);

    $this->get(route('training.manage'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Performance/Training/Manage')
                ->where('active', 'assign')
                ->hasAll([
                    'started' => 3,
                    'notStarted' => 3,
                    'completed' => 3,
                    'awaitingApproval' => 3
                ])
        );
});

it('returns unauthorized if the person does not have permission to create training', function () {
    $this->get(route('training.manage'))
        ->assertForbidden();
});
