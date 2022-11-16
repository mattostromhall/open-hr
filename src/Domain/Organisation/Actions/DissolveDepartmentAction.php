<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\Models\Department;

class DissolveDepartmentAction
{
    public function __construct(protected DeleteDepartmentAction $deleteDepartment)
    {
        //
    }

    public function execute(Department $department): bool
    {
        $deleted = $this->deleteDepartment->execute($department);

        if ($deleted) {
            $department->members()->update([
                'department_id' => null
            ]);
        }

        return $deleted;
    }
}
