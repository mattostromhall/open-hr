<?php

use Illuminate\Support\Facades\Storage;
use Support\Actions\CreateCsvAction;
use Support\DataTransferObjects\CsvData;

it('creates a csv', function () {
    $action = app(CreateCsvAction::class);

    $csvData = new CsvData(
        path: 'test/test-csv',
        headers: ['first', 'second', 'third'],
        records: [
            ['a', 'b', 'c'],
            ['d', 'e', 'f']
        ]
    );

    $action->execute($csvData);

    Storage::assertExists('test/test-csv.csv');
});

afterEach(function () {
    Storage::deleteDirectory('test');
});
