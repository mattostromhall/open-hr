<?php

namespace Support\Actions;

use Support\DataTransferObjects\ReportData;
use Support\Models\Report;

class CreateReportAction
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
