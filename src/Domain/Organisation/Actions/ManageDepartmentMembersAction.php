<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\Actions\Contracts\ManageDepartmentMembersActionInterface;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;

class ManageDepartmentMembersAction implements ManageDepartmentMembersActionInterface
{
    public function execute(Department $department, array $people): void
    {
        Person::query()
        ->whereIn('id', $people)
        ->update([
            'department_id' => $department->id
        ]);

        Person::query()
        ->whereNotIn('id', $people)
        ->where('department_id', $department->id)
        ->update([
            'department_id' => null
        ]);
    }
}
