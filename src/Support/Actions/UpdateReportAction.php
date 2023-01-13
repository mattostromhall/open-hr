<?php

namespace Support\Actions;

use Support\Actions\Contracts\UpdateReportActionInterface;
use Support\DataTransferObjects\ReportData;
use Support\Models\Report;

class UpdateReportAction implements UpdateReportActionInterface
{
    public function execute(Report $report, ReportData $data): bool
    {
        return $report->update([
            'label' => $data->label,
            'model' => $data->model,
            'condition_sets' => $data->condition_sets
        ]);
    }
}
