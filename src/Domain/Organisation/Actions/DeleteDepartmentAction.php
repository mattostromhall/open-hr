<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\Models\Department;

class DeleteDepartmentAction
{
    public function execute(Department $department): bool
    {
        return $department->delete();
    }
}
