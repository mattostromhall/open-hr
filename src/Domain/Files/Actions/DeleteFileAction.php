<?php

namespace Domain\Files\Actions;

use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\Models\Document;
use Illuminate\Support\Facades\Storage;

class DeleteFileAction
{
    public function execute(string $fileName): bool
    {
        return Storage::delete($fileName);
    }
}
