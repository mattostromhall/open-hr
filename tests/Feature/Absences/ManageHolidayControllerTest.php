<?php

use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;
use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the holiday management index', function () {
    $this->person->assign(Role::MANAGER);
    $directReport = Person::factory()->create([
        'manager_id' => $this->person->id
    ]);

    Holiday::factory()
        ->count(3)
        ->for($directReport)
        ->create();

    Holiday::factory()
        ->count(3)
        ->for($directReport)
        ->create(['status' => HolidayStatus::PENDING]);

    Holiday::factory()
        ->count(3)
        ->for($directReport)
        ->create(['status' => HolidayStatus::REJECTED]);

    $this->get(route('holiday.manage'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Absences/Holiday/Manage')
                ->where('active', 'pending')
                ->has('approved', 3)
                ->hasAll([
                    'approved.0.id',
                    'approved.0.start_at',
                    'approved.0.finish_at',
                    'approved.0.half_day',
                    'approved.0.notes',
                    'approved.1.id',
                    'approved.1.start_at',
                    'approved.1.finish_at',
                    'approved.1.half_day',
                    'approved.1.notes',
                    'approved.2.id',
                    'approved.2.start_at',
                    'approved.2.finish_at',
                    'approved.2.half_day',
                    'approved.2.notes'
                ])
                ->has('pending', 3)
                ->hasAll([
                    'pending.0.id',
                    'pending.0.start_at',
                    'pending.0.finish_at',
                    'pending.0.half_day',
                    'pending.0.notes',
                    'pending.1.id',
                    'pending.1.start_at',
                    'pending.1.finish_at',
                    'pending.1.half_day',
                    'pending.1.notes',
                    'pending.2.id',
                    'pending.2.start_at',
                    'pending.2.finish_at',
                    'pending.2.half_day',
                    'pending.2.notes'
                ])
                ->has('rejected', 3)
                ->hasAll([
                    'rejected.0.id',
                    'rejected.0.start_at',
                    'rejected.0.finish_at',
                    'rejected.0.half_day',
                    'rejected.0.notes',
                    'rejected.1.id',
                    'rejected.1.start_at',
                    'rejected.1.finish_at',
                    'rejected.1.half_day',
                    'rejected.1.notes',
                    'rejected.2.id',
                    'rejected.2.start_at',
                    'rejected.2.finish_at',
                    'rejected.2.half_day',
                    'rejected.2.notes'
                ])
        );
});

it('returns unauthorized if the person does not have permission to manage holidays', function () {
    $response = $this->get(route('holiday.manage'));

    $response->assertForbidden();
});
