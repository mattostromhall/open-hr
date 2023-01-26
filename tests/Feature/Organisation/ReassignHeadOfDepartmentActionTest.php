<?php

use Domain\Organisation\Actions\ReassignHeadOfDepartmentAction;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;

it('reassigns the head of department', function () {
    $department = Department::factory()->create();
    $newHeadOfDepartment = Person::factory()->create();
    $action = app(ReassignHeadOfDepartmentAction::class);

    $action->execute($department, $newHeadOfDepartment->id);

    $this->assertEquals($department->fresh()->head_of_department_id, $newHeadOfDepartment->id);
});
