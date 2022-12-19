<?php

namespace Support\Actions;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;

class CreateCsvAction
{
    /**
     * @throws CannotInsertRecord
     */
    public function execute(string $path, array $headers, array $records): Writer
    {
        $file = $path . '.csv';

        Storage::put($file, '');

        $csv = Writer::createFromPath(storage_path('app/') . $file);

        $csv->insertOne($headers);
        $csv->insertAll($records);

        return $csv;
    }
}
