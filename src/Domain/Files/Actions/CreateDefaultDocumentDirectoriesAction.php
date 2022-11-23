<?php

namespace Domain\Files\Actions;

use Illuminate\Support\Collection;

class CreateDefaultDocumentDirectoriesAction
{
    public function __construct(protected CreateDirectoryAction $createDirectory)
    {
        //
    }

    /**
     * @param Collection<string> $directories
     * @return void
     */
    public function execute(Collection $directories): void
    {
        $directories->each(
            fn (string $directory) =>
            $this->createDirectory->execute("documents/{$directory}")
        );
    }
}
