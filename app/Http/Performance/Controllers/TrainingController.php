<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreTrainingRequest;
use App\Http\Performance\Requests\UpdateTrainingRequest;
use App\Http\Performance\ViewModels\TrainingIndexViewModel;
use App\Http\Performance\ViewModels\TrainingViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\AmendTrainingAction;
use Domain\Performance\Actions\CancelTrainingAction;
use Domain\Performance\Actions\RequestTrainingAction;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TrainingController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Performance/Training/Index', new TrainingIndexViewModel());
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreTrainingRequest $request, RequestTrainingAction $requestTraining): RedirectResponse
    {
        $this->authorize('create', Training::class);

        $requestTraining->execute($request->trainingData());

        return back()->with('flash.success', 'Training request submitted!');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Training $training): Response
    {
        $this->authorize('view', $training);

        return Inertia::render('Performance/Training/Show', new TrainingViewModel($training));
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Training $training): Response
    {
        $this->authorize('update', $training);

        return Inertia::render('Performance/Training/Edit', new TrainingViewModel($training));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateTrainingRequest $request, Training $training, AmendTrainingAction $amendTraining): RedirectResponse
    {
        $this->authorize('update', $training);

        $updated = $amendTraining->execute($training, $request->trainingData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Training request, please try again.');
        }

        return redirect()->to(route('training.index'))->with('flash.success', 'Training updated!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Training $training, CancelTrainingAction $cancelTraining): RedirectResponse
    {
        $this->authorize('delete', $training);

        $deleted = $cancelTraining->execute($training, TrainingData::from($training->toArray()));

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with cancelling the Training request, please try again.');
        }

        return redirect()->to(route('training.index'))->with('flash.success', 'Training request cancelled!');
    }
}
