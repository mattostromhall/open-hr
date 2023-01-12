<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\Actions\Contracts\DeleteDepartmentActionInterface;
use Domain\Organisation\Actions\Contracts\DissolveDepartmentActionInterface;
use Domain\Organisation\Models\Department;

class DissolveDepartmentAction implements DissolveDepartmentActionInterface
{
    public function __construct(protected DeleteDepartmentActionInterface $deleteDepartment)
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
