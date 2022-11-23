<?php

namespace Domain\Files\Commands;

use Domain\Files\Actions\CreateDefaultDocumentDirectoriesAction;
use Domain\Files\Enums\DocumentableType;
use Illuminate\Console\Command;

class ScaffoldDefaults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scaffold:defaults';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold the defaults required for the application to run.';

    public function handle(CreateDefaultDocumentDirectoriesAction $createDefaultDocumentDirectories): int
    {
        $defaultDocumentDirectories = collect(DocumentableType::cases())->map(fn (DocumentableType $type) => $type->plural());

        $createDefaultDocumentDirectories->execute($defaultDocumentDirectories);

        return self::SUCCESS;
    }
}
