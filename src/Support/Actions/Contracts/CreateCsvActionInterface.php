<?php

namespace Support\Actions\Contracts;

use League\Csv\Writer;
use Support\DataTransferObjects\CsvData;

interface CreateCsvActionInterface
{
    public function execute(CsvData $data): Writer;
}
