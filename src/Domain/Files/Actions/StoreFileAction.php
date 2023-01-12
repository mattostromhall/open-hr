<?php

namespace Domain\Files\Actions;

use Domain\Files\Actions\Contracts\StoreFileActionInterface;
use Domain\Files\DataTransferObjects\UploadedFileData;
use Illuminate\Support\Str;

class StoreFileAction implements StoreFileActionInterface
{
    public function execute(UploadedFileData $data): bool|string
    {
        return $data->file->storeAs($data->path, $this->fileName($data), $data->disk);
    }

    protected function fileName($data): string
    {
        $name = $data->name ?? Str::random(40);

        return $name . '.' . $data->file->extension();
    }
}
