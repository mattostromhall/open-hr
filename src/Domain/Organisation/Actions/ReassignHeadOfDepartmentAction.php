<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\Actions\Contracts\ReassignHeadOfDepartmentActionInterface;
use Domain\Organisation\Models\Department;

class ReassignHeadOfDepartmentAction implements ReassignHeadOfDepartmentActionInterface
{
    public function execute(Department $department, int $newHeadOfDepartmentId): bool
    {
        //
    }
}
