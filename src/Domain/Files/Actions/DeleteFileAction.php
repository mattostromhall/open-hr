<?php

namespace Domain\Files\Actions;

use Domain\Files\Actions\Contracts\DeleteFileActionInterface;
use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\Models\Document;
use Illuminate\Support\Facades\Storage;

class DeleteFileAction implements DeleteFileActionInterface
{
    public function execute(string $fileName): bool
    {
        return Storage::delete($fileName);
    }
}
