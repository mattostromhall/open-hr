<?php

namespace Domain\Files\Actions;

use Domain\Files\Actions\Contracts\CreateDefaultDocumentDirectoriesActionInterface;
use Domain\Files\Actions\Contracts\CreateDirectoryActionInterface;
use Domain\Files\Enums\DocumentableType;

class CreateDefaultDocumentDirectoriesAction implements CreateDefaultDocumentDirectoriesActionInterface
{
    public function __construct(protected CreateDirectoryActionInterface $createDirectory)
    {
        //
    }

    public function execute(): void
    {
        collect(DocumentableType::cases())
            ->map(fn (DocumentableType $type) => $type->plural())
            ->each(
                fn (string $directory) =>
                $this->createDirectory->execute("documents/{$directory}")
            );
    }
}
