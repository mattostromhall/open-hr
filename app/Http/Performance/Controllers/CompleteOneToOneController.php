<?php

namespace App\Http\Performance\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\CompleteOneToOneAction;
use Domain\Performance\Models\OneToOne;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompleteOneToOneController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(
        Request $request,
        OneToOne $oneToOne,
        CompleteOneToOneAction $completeOneToOne
    ): RedirectResponse {
        $this->authorize('complete', $oneToOne);

        $completed = $completeOneToOne->execute($oneToOne);

        if (! $completed) {
            return back()->with('flash.error', 'There was a problem with completing the One-to-one, please try again.');
        }

        return back()->with('flash.success', 'One-to-one marked as complete!');
    }
}
