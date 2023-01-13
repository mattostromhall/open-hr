<?php

namespace Support\Actions;

use Support\Actions\Contracts\DeleteReportActionInterface;
use Support\Models\Report;

class DeleteReportAction implements DeleteReportActionInterface
{
    public function execute(Report $report): bool
    {
        return $report->delete();
    }
}
