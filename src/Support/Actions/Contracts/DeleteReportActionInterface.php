<?php

namespace Support\Actions\Contracts;

use Support\Models\Report;

interface DeleteReportActionInterface
{
    public function execute(Report $report): bool;
}
