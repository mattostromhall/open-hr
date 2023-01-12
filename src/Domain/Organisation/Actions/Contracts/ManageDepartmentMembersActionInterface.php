<?php

namespace Domain\Organisation\Actions\Contracts;

use Domain\Organisation\Models\Department;

interface ManageDepartmentMembersActionInterface
{
    public function execute(Department $department, array $people): void;
}
