<?php

namespace Domain\Organisation\Actions\Contracts;

interface BulkDeleteDepartmentsActionInterface
{
    /**
     * @param array<int> $departments
     * @return bool
     */
    public function execute(array $departments): bool;
}
