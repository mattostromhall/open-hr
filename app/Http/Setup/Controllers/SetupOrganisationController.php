<?php

namespace App\Http\Setup\Controllers;

use App\Http\Setup\Requests\StoreOrganisationRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Auth\Actions\Contracts\AssignRoleActionInterface;
use Domain\Auth\Enums\Role;
use Domain\Files\Actions\Contracts\CreateDefaultDocumentDirectoriesActionInterface;
use Domain\Organisation\Actions\Contracts\CreateOrganisationActionInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class SetupOrganisationController extends Controller
{
    public function __invoke(
        CreateDefaultDocumentDirectoriesActionInterface $createDefaultDocumentDirectories,
        StoreOrganisationRequest $request,
        CreateOrganisationActionInterface $createOrganisation,
        AssignRoleActionInterface $assignRole
    ): RedirectResponse {
        DB::transaction(
            function () use ($createDefaultDocumentDirectories, $createOrganisation, $assignRole, $request) {
                $createDefaultDocumentDirectories->execute();

                $createOrganisation->execute($request->organisationData());

                $assignRole->execute($request->user(), Role::ADMIN);
            }
        );

        return back();
    }
}
