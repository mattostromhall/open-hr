<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\Models\Department;

class UpdateDepartmentAction
{
    public function execute(Department $department, DepartmentData $data): bool
    {
        return $department->update([
            'name' => $data->name,
            'head_of_department_id' => $data->head_of_department->id,
        ]);
    }
}
