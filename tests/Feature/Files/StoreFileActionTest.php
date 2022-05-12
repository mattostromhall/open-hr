<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Domain\Files\Actions\StoreFileAction;
use Domain\Files\DataTransferObjects\UploadedFileData;

it('stores a file with a name', function () {
    $action = app(StoreFileAction::class);
    $file = UploadedFile::fake()->create('document.pdf', 10);
    $uploadedFileData = new UploadedFileData(file: $file, path: 'test', name: 'document');

    $action->execute($uploadedFileData);

    Storage::assertExists('test/document.pdf');
});

it('stores a file with a hash if no name is provided', function () {
    $action = app(StoreFileAction::class);
    $file = UploadedFile::fake()->create('document.pdf', 10);
    $uploadedFileData = new UploadedFileData(file: $file, path: 'test');

    $result = $action->execute($uploadedFileData);

    Storage::assertExists($result);
});
