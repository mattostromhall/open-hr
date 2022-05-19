<?php

namespace App\Http\Setup\Controllers;

use App\Http\People\Requests\StorePersonRequest;
use App\Http\Support\Controllers\Controller;
use Domain\People\Actions\CreatePersonAction;
use Domain\People\DataTransferObjects\PersonData;
use Illuminate\Http\RedirectResponse;

class StorePersonController extends Controller
{
    public function __invoke(StorePersonRequest $request, CreatePersonAction $createHR): RedirectResponse
    {
        $createHR->execute(
            PersonData::from($request->validatedWithUser())
        );

        return redirect()->route('dashboard');
    }
}
