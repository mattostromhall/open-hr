<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\Actions\Contracts\DeleteDepartmentActionInterface;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;

class DeleteDepartmentAction implements DeleteDepartmentActionInterface
{
    public function execute(Department $department): bool
    {
        $department->members()
            ->update([
                'department_id' => null
            ]);

        return $department->delete();
    }
}
