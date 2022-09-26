<?php

use Domain\Organisation\Actions\ManageDepartmentMembersAction;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;

it('adds members to a department', function () {
    $department = Department::factory()->create();
    $people = Person::factory()
        ->count(4)
        ->create();
    $action = app(ManageDepartmentMembersAction::class);

    $action->execute($department, $people->skip(1)->pluck('id')->toArray());

    expect(
        Person::query()
            ->where('department_id', $department->id)
            ->count()
    )->toBe(3);

});

it('removes a member from a department if no longer a member', function () {
    $department = Department::factory()->create();
    $people = Person::factory()
        ->count(3)
        ->create();
    $action = app(ManageDepartmentMembersAction::class);

    $action->execute($department, $people->pluck('id')->toArray());

    expect(
        Person::query()
            ->where('department_id', $department->id)
            ->count()
    )->toBe(3);

    $action->execute($department, $people->skip(1)->pluck('id')->toArray());

    expect(
        Person::query()
            ->where('department_id', $department->id)
            ->count()
    )->toBe(2)
        ->and(
            Person::query()
                ->firstWhere('id', $people[0]->id)
                ->department_id
        )->toBeNull();
});
