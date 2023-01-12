<?php

namespace Domain\Files\Actions\Contracts;

use Domain\Files\DataTransferObjects\UploadedFileData;

interface StoreFileActionInterface
{
    public function execute(UploadedFileData $data): bool|string;
}
