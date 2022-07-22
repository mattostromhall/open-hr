<?php

namespace Domain\Files\Actions;

use Illuminate\Support\Str;
use Domain\Files\DataTransferObjects\UploadedFileData;

class StoreFileAction
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
