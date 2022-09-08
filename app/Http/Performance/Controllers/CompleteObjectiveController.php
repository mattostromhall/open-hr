<?php

namespace App\Http\Performance\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\CompleteObjectiveAction;
use Domain\Performance\Models\Objective;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompleteObjectiveController extends Controller
{
    public function __invoke(Request $request, Objective $objective, CompleteObjectiveAction $completeObjective): RedirectResponse
    {
        $completed = $completeObjective->execute($objective);

        if (! $completed) {
            return back()->with('flash.error', 'There was a problem with completing the Objective, please try again.');
        }

        return back()->with('flash.success', 'Objective marked as complete!');
    }
}
