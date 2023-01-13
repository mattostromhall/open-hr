<?php

namespace App\Http\Performance\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\Contracts\CompleteObjectiveActionInterface;
use Domain\Performance\Models\Objective;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompleteObjectiveController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Objective $objective, CompleteObjectiveActionInterface $completeObjective): RedirectResponse
    {
        $this->authorize('complete', $objective);

        $completed = $completeObjective->execute($objective);

        if (! $completed) {
            return back()->with('flash.error', 'There was a problem with completing the Objective, please try again.');
        }

        return back()->with('flash.success', 'Objective marked as complete!');
    }
}
