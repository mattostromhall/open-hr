<?php

namespace Support\Actions;

use Support\Models\Report;

class DeleteReportAction
{
    public function execute(Report $report): bool
    {
        return $report->delete();
    }
}
