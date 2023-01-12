<?php

namespace Domain\Files\Actions\Contracts;

interface DeleteDirectoryActionInterface
{
    public function execute(string $path): bool;
}
