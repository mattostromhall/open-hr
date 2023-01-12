<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\Actions\Contracts\DeleteDepartmentActionInterface;
use Domain\Organisation\Models\Department;

class DeleteDepartmentAction implements DeleteDepartmentActionInterface
{
    public function execute(Department $department): bool
    {
        return $department->delete();
    }
}
