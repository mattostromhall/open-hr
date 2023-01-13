<?php

namespace App\Http\Performance\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\Contracts\StartTrainingActionInterface;
use Domain\Performance\Models\Training;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StartTrainingController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Training $training, StartTrainingActionInterface $startTraining): RedirectResponse
    {
        $this->authorize('update', $training);

        $started = $startTraining->execute($training);

        if (! $started) {
            return back()->with('flash.error', 'There was a problem with starting the Training, please try again.');
        }

        return redirect(route('training.index'))->with('flash.success', 'Training started!');
    }
}
