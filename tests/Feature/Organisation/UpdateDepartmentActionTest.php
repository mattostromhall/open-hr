<?php

use Domain\Organisation\Actions\UpdateDepartmentAction;
use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;

it('updates a department', function () {
    $person = Person::factory()->create();
    $department = Department::factory()->create();
    $action = app(UpdateDepartmentAction::class);
    $departmentData = new DepartmentData(
        name: 'Updated name',
        head_of_department: $person
    );

    $this->assertModelExists($department);

    $action->execute($department, $departmentData);

    $this->assertDatabaseHas('departments', [
        'name' => $departmentData->name,
        'head_of_department_id' => $departmentData->head_of_department->id
    ]);
});
