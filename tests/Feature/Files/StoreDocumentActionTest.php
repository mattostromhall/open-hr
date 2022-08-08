<?php

use Domain\Files\Actions\StoreDocumentAction;
use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\Enums\DocumentableType;

it('stores a document', function () {
    $action = app(StoreDocumentAction::class);
    $documentData = new DocumentData(
        name: 'test document',
        directory: '/test',
        size: 1024,
        extension: 'pdf',
        disk: 'local',
        documentable_id: 1,
        documentable_type: DocumentableType::PEOPLE
    );

    $action->execute($documentData);

    $this->assertDatabaseHas('documents', [
        'name' => $documentData->name,
        'directory' => $documentData->directory,
        'size' => $documentData->size,
        'extension' => $documentData->extension,
        'disk' => $documentData->disk,
        'documentable_id' => $documentData->documentable_id,
        'documentable_type' => $documentData->documentable_type
    ]);
});
