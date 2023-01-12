<?php

namespace Domain\Organisation\Actions\Contracts;

use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\Models\Department;

interface AmendDepartmentActionInterface
{
    public function execute(Department $department, DepartmentData $data): bool;
}
