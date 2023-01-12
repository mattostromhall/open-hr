<?php

namespace Domain\Organisation\Actions\Contracts;

use Domain\Organisation\Models\Department;

interface DeleteDepartmentActionInterface
{
    public function execute(Department $department): bool;
}
