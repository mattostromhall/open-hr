<?php

namespace Domain\Files\Actions\Contracts;

use Domain\Files\DataTransferObjects\UploadedDocumentData;

interface UploadDocumentActionInterface
{
    public function execute(UploadedDocumentData $data): void;
}
