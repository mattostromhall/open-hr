<?php

namespace App\Http\Setup\Controllers;

use App\Http\Setup\Requests\StoreOrganisationRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Auth\Actions\AssignRoleAction;
use Domain\Auth\Enums\Role;
use Domain\Files\Actions\CreateDefaultDocumentDirectoriesAction;
use Domain\Organisation\Actions\CreateOrganisationAction;
use Illuminate\Http\RedirectResponse;

class SetupOrganisationController extends Controller
{
    public function __invoke(
        CreateDefaultDocumentDirectoriesAction $createDefaultDocumentDirectories,
        StoreOrganisationRequest $request,
        CreateOrganisationAction $createOrganisation,
        AssignRoleAction $assignRole
    ): RedirectResponse {
        $createDefaultDocumentDirectories->execute();

        $createOrganisation->execute($request->organisationData());

        $assignRole->execute($request->user(), Role::ADMIN);

        return back();
    }
}
