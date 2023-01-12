<?php

namespace Domain\Files\Actions\Contracts;

use Illuminate\Support\Collection;

interface UploadDocumentsActionInterface
{
    public function execute(Collection $uploadedDocuments): void;
}
