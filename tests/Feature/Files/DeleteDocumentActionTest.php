<?php

use Domain\Files\Actions\DeleteDocumentAction;
use Domain\Files\Models\Document;

it('deletes the document', function () {
    $document = Document::factory()->create();
    $action = app(DeleteDocumentAction::class);

    $this->assertNotSoftDeleted($document);

    $action->execute($document);

    $this->assertSoftDeleted($document);
});
