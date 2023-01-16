<?php

namespace Support\Actions;

use Support\Actions\Contracts\BulkDeleteReportsActionInterface;
use Support\Models\Report;

class BulkDeleteReportsAction implements BulkDeleteReportsActionInterface
{
    /**
     * @param array<int> $reports
     * @return bool
     */
    public function execute(array $reports): bool
    {
        return Report::query()
            ->whereIn('id', $reports)
            ->delete();
    }
}
