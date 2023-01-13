<?php

namespace Support\Actions\Contracts;

use Support\DataTransferObjects\ReportData;
use Support\Models\Report;

interface UpdateReportActionInterface
{
    public function execute(Report $report, ReportData $data): bool;
}
