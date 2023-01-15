<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\Actions\Contracts\BulkDeleteDepartmentsActionInterface;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;

class BulkDeleteDepartmentsAction implements BulkDeleteDepartmentsActionInterface
{
    /**
     * @param array<int> $departments
     * @return bool
     */
    public function execute(array $departments): bool
    {
        Person::query()
            ->whereIn('department_id', $departments)
            ->update([
                'department_id' => null
            ]);

        return Department::query()
            ->whereIn('id', $departments)
            ->delete();
    }
}
