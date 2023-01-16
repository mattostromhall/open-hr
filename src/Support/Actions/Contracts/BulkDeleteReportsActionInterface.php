<?php

namespace Support\Actions\Contracts;

interface BulkDeleteReportsActionInterface
{
    /**
     * @param array<int> $reports
     * @return bool
     */
    public function execute(array $reports): bool;
}
