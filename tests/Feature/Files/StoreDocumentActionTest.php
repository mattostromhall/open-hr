<?php

use Domain\Files\Actions\StoreDocumentAction;
use Domain\Files\DataTransferObjects\DocumentData;

it('stores a document', function () {
    $action = app(StoreDocumentAction::class);
    $documentData = new DocumentData(
        name: 'test document',
        path: '/test',
        disk: 'local',
        documentable_id: 1,
        documentable_type: 'person'
    );

    $action->execute($documentData);

    $this->assertDatabaseHas('documents', [
        'name' => $documentData->name,
        'path' => $documentData->path,
        'disk' => $documentData->disk,
        'documentable_id' => $documentData->documentable_id,
        'documentable_type' => $documentData->documentable_type
    ]);
});
