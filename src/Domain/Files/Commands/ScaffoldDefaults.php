<?php

namespace Domain\Files\Commands;

use Domain\Auth\Actions\Contracts\CreateAbilitiesActionInterface;
use Domain\Auth\Actions\Contracts\CreateRolesActionInterface;
use Domain\Auth\Actions\Contracts\GiveAbilitiesToRolesActionInterface;
use Domain\Files\Actions\CreateDefaultDocumentDirectoriesAction;
use Exception;
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

    public function handle(
        CreateDefaultDocumentDirectoriesAction $createDefaultDocumentDirectories,
        CreateRolesActionInterface $createRoles,
        CreateAbilitiesActionInterface $createAbilities,
        GiveAbilitiesToRolesActionInterface $giveAbilitiesToRoles
    ): int {
        try {
            $createDefaultDocumentDirectories->execute();
            $createRoles->execute();
            $createAbilities->execute();
            $giveAbilitiesToRoles->execute();
        } catch (Exception $e) {
            $this->line($e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
