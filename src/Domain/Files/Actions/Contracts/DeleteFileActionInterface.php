<?php

namespace Domain\Files\Actions\Contracts;

interface DeleteFileActionInterface
{
    public function execute(string $fileName): bool;
}
