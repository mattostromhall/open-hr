<?php

namespace App\Http\Setup\Controllers;

use App\Http\People\Requests\StorePersonRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Organisation\Actions\CompleteSetupAction;
use Domain\People\Actions\CreatePersonAction;
use Domain\People\DataTransferObjects\PersonData;
use Illuminate\Http\RedirectResponse;

class SetupPersonController extends Controller
{
    public function __invoke(StorePersonRequest $request, CreatePersonAction $createPerson, CompleteSetupAction $completeSetup): RedirectResponse
    {
        $createPerson->execute($request->personData());

        $completeSetup->execute();

        return redirect()->route('dashboard');
    }
}
