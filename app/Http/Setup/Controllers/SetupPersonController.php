<?php

namespace App\Http\Setup\Controllers;

use App\Http\People\Requests\StorePersonRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Organisation\Actions\Contracts\CompleteSetupActionInterface;
use Domain\People\Actions\Contracts\CreatePersonActionInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class SetupPersonController extends Controller
{
    public function __invoke(StorePersonRequest $request, CreatePersonActionInterface $createPerson, CompleteSetupActionInterface $completeSetup): RedirectResponse
    {
        DB::transaction(
            function () use ($createPerson, $completeSetup, $request) {
                $createPerson->execute($request->personData());

                $completeSetup->execute();
            }
        );

        return redirect()->route('dashboard');
    }
}
