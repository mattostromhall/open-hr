<?php

namespace App\Http\Setup\Controllers;

use App\Http\People\Requests\StorePersonRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Files\Actions\Contracts\CreateDirectoryActionInterface;
use Domain\Organisation\Actions\Contracts\CompleteSetupActionInterface;
use Domain\People\Actions\Contracts\CreatePersonActionInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class SetupPersonController extends Controller
{
    public function __invoke(
        StorePersonRequest $request,
        CreatePersonActionInterface $createPerson,
        CreateDirectoryActionInterface $createDirectory,
        CompleteSetupActionInterface $completeSetup
    ): RedirectResponse {
        DB::transaction(
            function () use ($createPerson, $createDirectory, $completeSetup, $request) {
                $data = $request->personData();

                $createPerson->execute($data);
                $createDirectory->execute("documents/people/{$data->first_name} {$data->last_name}");

                $completeSetup->execute();
            }
        );

        return redirect()->route('dashboard');
    }
}
