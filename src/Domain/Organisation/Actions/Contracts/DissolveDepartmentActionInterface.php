<?php

namespace Domain\Organisation\Actions\Contracts;

use Domain\Organisation\Models\Department;

interface DissolveDepartmentActionInterface
{
    public function execute(Department $department): bool;
}
