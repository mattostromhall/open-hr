<?php

use Domain\Organisation\Actions\DeleteDepartmentAction;
use Domain\Organisation\Actions\DissolveDepartmentAction;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;

it('dissolves the department by deleting it and removing any department members', function () {
    $department = Department::factory()->create();
    $people = Person::factory()->for($department)->count(3)->create();
    $action = app(DissolveDepartmentAction::class);

    $this->assertNotSoftDeleted($department);

    $people->each(fn (Person $person) => $this->assertEquals($person->department_id, $department->id));

    $action->execute($department);

    $people->each(fn (Person $person) => $this->assertNull($person->fresh()->department_id));

    $this->assertSoftDeleted($department);
});
