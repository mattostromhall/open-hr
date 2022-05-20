<?php

namespace App\Http\Setup\Controllers;

use App\Http\Setup\Requests\StoreOrganisationRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Auth\Actions\AssignHrRoleAction;
use Domain\Organisation\Actions\CreateOrganisationAction;
use Domain\Organisation\DataTransferObjects\OrganisationData;
use Illuminate\Http\RedirectResponse;

class SetupOrganisationController extends Controller
{
    public function __invoke(
        StoreOrganisationRequest $request,
        CreateOrganisationAction $createOrganisation,
        AssignHrRoleAction $assignHrRole
    ): RedirectResponse {
        $createOrganisation->execute(
            OrganisationData::from($request->validated())
        );

        $assignHrRole->execute($request->user());

        return back();
    }
}
