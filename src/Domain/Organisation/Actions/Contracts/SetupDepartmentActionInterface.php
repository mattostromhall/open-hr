<?php

namespace Domain\Organisation\Actions\Contracts;

use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\Models\Department;

interface SetupDepartmentActionInterface
{
    public function execute(DepartmentData $data): Department;
}
