<?php

namespace Domain\Files\Actions;

use Domain\Files\Enums\DocumentableType;
use Illuminate\Support\Collection;

class CreateDefaultDocumentDirectoriesAction
{
    public function __construct(protected CreateDirectoryAction $createDirectory)
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
