<?php

use Domain\Organisation\Actions\BulkDeleteDepartmentsAction;
use Domain\Organisation\Models\Department;

it('bulk deletes the departments', function () {
    $departments = Department::factory()->count(3)->create();
    $action = app(BulkDeleteDepartmentsAction::class);

    $departments->each(fn (Department $department) => $this->assertNotSoftDeleted($department));

    $action->execute($departments->pluck('id')->toArray());

    $departments->each(fn (Department $department) => $this->assertSoftDeleted($department));
});
