<?php

namespace Support\Actions;

use Illuminate\Support\Facades\Storage;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use Support\Actions\Contracts\CreateCsvActionInterface;
use Support\DataTransferObjects\CsvData;

class CreateCsvAction implements CreateCsvActionInterface
{
    /**
     * @throws CannotInsertRecord
     */
    public function execute(CsvData $data): Writer
    {
        $file = $data->path . '.csv';

        Storage::put($file, '');

        $csv = Writer::createFromPath(storage_path('app/') . $file);

        $csv->insertOne($data->headers);
        $csv->insertAll($data->records);

        return $csv;
    }
}
