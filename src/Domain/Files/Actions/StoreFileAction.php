<?php

namespace Domain\Files\Actions;

use Illuminate\Support\Str;
use Domain\Files\DataTransferObjects\UploadedFileData;

class StoreFileAction
{
    public function execute(UploadedFileData $fileData): bool|string
    {
        return $fileData->file->storeAs($fileData->path, $this->fileName($fileData), $fileData->disk);
    }

    protected function fileName($fileData): string
    {
        $name = $fileData->name ?? Str::random(40);

        return $name . '.' . $fileData->file->extension();
    }
}
