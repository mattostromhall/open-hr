<?php

namespace App\Http\Setup\Controllers;

use App\Http\Setup\Requests\StoreOrganisationRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Organisation\Actions\CreateOrganisationAction;
use Domain\Organisation\DataTransferObjects\OrganisationData;
use Illuminate\Http\RedirectResponse;

class StoreOrganisationController extends Controller
{
    public function __invoke(StoreOrganisationRequest $request, CreateOrganisationAction $createOrganisation): RedirectResponse
    {
        $createOrganisation->execute(
            OrganisationData::from($request->validated())
        );

        return back();
    }
}
