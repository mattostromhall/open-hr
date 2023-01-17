<?php

namespace Domain\Recruitment\Actions\Contracts;

interface BulkDeleteApplicationsActionInterface
{
    /**
     * @param array<int> $applications
     * @return bool
     */
    public function execute(array $applications): bool;
}
