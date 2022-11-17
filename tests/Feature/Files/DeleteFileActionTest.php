<?php

use Domain\Files\Actions\DeleteFileAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Domain\Files\Actions\StoreFileAction;
use Domain\Files\DataTransferObjects\UploadedFileData;

it('deletes the file with the given name', function () {
    $storeAction = app(StoreFileAction::class);
    $file = UploadedFile::fake()->create('document.pdf', 10);
    $uploadedFileData = new UploadedFileData(file: $file, path: 'test', name: 'document');

    $storeAction->execute($uploadedFileData);

    Storage::assertExists('test/document.pdf');

    $deleteAction = app(DeleteFileAction::class);

    $deleteAction->execute('test/document.pdf');

    Storage::assertMissing('test/document.pdf');
});
