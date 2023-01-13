<?php

namespace Support\Actions\Contracts;

use Support\DataTransferObjects\ReportData;
use Support\Models\Report;

interface CreateReportActionInterface
{
    public function execute(ReportData $data): Report;
}
