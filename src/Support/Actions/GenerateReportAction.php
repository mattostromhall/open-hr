<?php

namespace Support\Actions;

use Illuminate\Support\Str;
use League\Csv\CannotInsertRecord;
use Support\DataTransferObjects\ReportableColumnData;
use Support\DataTransferObjects\ReportData;
use Support\Models\Report;
use Support\Services\ReportBuilder;

class GenerateReportAction
{
    public function __construct(protected CreateCsvAction $createCsv)
    {
        //
    }

    /**
     * @throws CannotInsertRecord
     */
    public function execute(ReportData $data): string
    {
        $reportData = ReportBuilder::build($data)->run();

        $headers = Report::FQCN($data->model)::reportableColumns()
            ->map(fn (ReportableColumnData $data) => $data->display)
            ->toArray();

        $path = 'reports/' . $data->label ?? Str::random();

        $this->createCsv->execute($path, $headers, $reportData->toArray());

        return  $path . '.csv';
    }
}
