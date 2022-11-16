<?php

use Domain\Organisation\Actions\DeleteDepartmentAction;
use Domain\Organisation\Models\Department;

it('deletes the department', function () {
    $department = Department::factory()->create();
    $action = app(DeleteDepartmentAction::class);

    $this->assertNotSoftDeleted($department);

    $action->execute($department);

    $this->assertSoftDeleted($department);
});
