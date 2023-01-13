<?php

namespace Support\Actions\Contracts;

use Support\DataTransferObjects\ReportData;

interface GenerateReportActionInterface
{
    public function execute(ReportData $data): string;
}
