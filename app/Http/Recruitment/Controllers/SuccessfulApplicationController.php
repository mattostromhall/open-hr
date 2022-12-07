<?php

namespace App\Http\Recruitment\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Recruitment\Actions\UpdateApplicationStatusAction;
use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Application;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SuccessfulApplicationController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Application $application, UpdateApplicationStatusAction $updateStatus): RedirectResponse
    {
        $this->authorize('update', $application);

        $successful = $updateStatus->execute($application, ApplicationStatus::SUCCESSFUL);

        if (! $successful) {
            return back()->with('flash.error', 'There was a problem with marking the Application as successful, please try again.');
        }

        return back()->with('flash.success', 'Application marked as successful!');
    }
}
