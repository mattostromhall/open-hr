<?php

use Domain\Organisation\Actions\CreateDepartmentAction;
use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\People\Models\Person;

it('creates a department', function () {
    $person = Person::factory()->create();
    $action = app(CreateDepartmentAction::class);
    $departmentData = new DepartmentData(
        name: 'Technology',
        head: $person
    );

    $action->execute($departmentData);

    $this->assertDatabaseHas('departments', [
        'name' => 'Technology',
        'head_of_department_id' => $departmentData->head->id
    ]);
});
