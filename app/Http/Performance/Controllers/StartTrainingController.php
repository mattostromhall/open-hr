<?php

namespace App\Http\Performance\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\StartTrainingAction;
use Domain\Performance\Models\Training;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StartTrainingController extends Controller
{
    public function __invoke(Request $request, Training $training, StartTrainingAction $startTraining): RedirectResponse
    {
        $started = $startTraining->execute($training);

        if (! $started) {
            return back()->with('flash.error', 'There was a problem with starting the Training, please try again.');
        }

        return redirect(route('training.index'))->with('flash.success', 'Training started!');
    }
}
