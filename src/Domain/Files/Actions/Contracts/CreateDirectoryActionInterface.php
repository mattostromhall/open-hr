<?php

namespace Domain\Files\Actions\Contracts;

interface CreateDirectoryActionInterface
{
    public function execute(string $path): bool;
}
