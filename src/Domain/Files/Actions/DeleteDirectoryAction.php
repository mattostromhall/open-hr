<?php

namespace Domain\Files\Actions;

use Domain\Files\Actions\Contracts\DeleteDirectoryActionInterface;
use Illuminate\Support\Facades\Storage;

class DeleteDirectoryAction implements DeleteDirectoryActionInterface
{
    public function execute(string $path): bool
    {
        return Storage::deleteDirectory($path);
    }
}
