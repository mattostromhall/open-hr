<?php

namespace Support\Actions;

use Support\DataTransferObjects\ReportData;
use Support\Models\Report;

class SaveReportAction
{
    public function execute(ReportData $data): Report
    {
        return Report::create([
            'label' => $data->label,
            'model' => $data->model,
            'condition_sets' => $data->condition_sets
        ]);
    }
}
