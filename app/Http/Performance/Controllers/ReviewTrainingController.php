<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreTrainingRequest;
use App\Http\Performance\Requests\UpdateTrainingRequest;
use App\Http\Performance\ViewModels\ReviewTrainingViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\RequestTrainingAction;
use Domain\Performance\Actions\ReviewTrainingAction;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ReviewTrainingController extends Controller
{
    public function show(Training $training): Response
    {
        return Inertia::render('Performance/Training/Review', new ReviewTrainingViewModel($training));
    }

    public function update(UpdateTrainingRequest $request, Training $training, ReviewTrainingAction $reviewTraining): RedirectResponse
    {
        $trainingData = TrainingData::from([
            ...$training->only('status', 'state', 'description', 'provider', 'location', 'cost', 'cost_currency', 'duration', 'notes'),
            ...$request->filteredValidatedData()
        ]);

        $reviewed = $reviewTraining->execute($training, $trainingData);

        if (! $reviewed) {
            return back()->with('flash.error', 'There was a problem when reviewing the Training request, please try again.');
        }

        return redirect()->to(route('dashboard'))->with('flash.success', "Training {$trainingData->status->statusDisplay()}.");
    }
}