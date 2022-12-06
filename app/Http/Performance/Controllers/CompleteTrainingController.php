<?php

namespace App\Http\Performance\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\CompleteTrainingAction;
use Domain\Performance\Models\Training;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompleteTrainingController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Training $training, CompleteTrainingAction $completeTraining): RedirectResponse
    {
        $this->authorize('complete', $training);

        $completed = $completeTraining->execute($training);

        if (! $completed) {
            return back()->with('flash.error', 'There was a problem with completing the Training, please try again.');
        }

        return redirect(route('training.index'))->with('flash.success', 'Training completed!');
    }
}
