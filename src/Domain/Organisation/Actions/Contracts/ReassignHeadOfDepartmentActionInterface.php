<?php

namespace Domain\Organisation\Actions\Contracts;

use Domain\Organisation\Models\Department;

interface ReassignHeadOfDepartmentActionInterface
{
    public function execute(Department $department, int $newHeadOfDepartmentId): bool;
}
