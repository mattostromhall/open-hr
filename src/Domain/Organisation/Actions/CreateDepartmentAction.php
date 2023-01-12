<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\Actions\Contracts\CreateDepartmentActionInterface;
use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\Models\Department;

class CreateDepartmentAction implements CreateDepartmentActionInterface
{
    public function execute(DepartmentData $data): Department
    {
        return Department::create([
            'name' => $data->name,
            'head_of_department_id' => $data->head_of_department->id,
        ]);
    }
}
