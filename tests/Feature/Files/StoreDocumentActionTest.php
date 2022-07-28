<?php

use Domain\Files\Actions\StoreDocumentAction;
use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\Enums\DocumentableType;

it('stores a document', function () {
    $action = app(StoreDocumentAction::class);
    $documentData = new DocumentData(
        name: 'test document.pdf',
        directory: '/test',
        disk: 'local',
        documentable_id: 1,
        documentable_type: DocumentableType::PEOPLE
    );

    $action->execute($documentData);

    $this->assertDatabaseHas('documents', [
        'name' => $documentData->name,
        'directory' => $documentData->directory,
        'disk' => $documentData->disk,
        'documentable_id' => $documentData->documentable_id,
        'documentable_type' => $documentData->documentable_type
    ]);
});
