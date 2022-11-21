<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreObjectiveRequest;
use App\Http\Performance\Requests\UpdateObjectiveRequest;
use App\Http\Performance\ViewModels\ObjectiveViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\AmendObjectiveAction;
use Domain\Performance\Actions\SetObjectiveAction;
use Domain\Performance\Actions\UnsetObjectiveAction;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ObjectiveController extends Controller
{
    public function store(StoreObjectiveRequest $request, SetObjectiveAction $setObjective): RedirectResponse
    {
        $objective = $setObjective->execute($request->objectiveData());

        return redirect(route('objective.edit', ['objective' => $objective]))
            ->with('flash.success', 'Objective successfully created!');
    }

    public function show(Objective $objective): Response
    {
        return Inertia::render('Performance/Objectives/Show', new ObjectiveViewModel($objective));
    }

    public function edit(Objective $objective): Response
    {
        return Inertia::render('Performance/Objectives/Edit', new ObjectiveViewModel($objective));
    }

    public function update(UpdateObjectiveRequest $request, Objective $objective, AmendObjectiveAction $amendObjective): RedirectResponse
    {
        $updated = $amendObjective->execute($objective, $request->objectiveData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Objective, please try again.');
        }

        return redirect()
            ->to(route('performance.index'))
            ->with('flash.success', 'Objective updated!');
    }

    public function destroy(Objective $objective, UnsetObjectiveAction $unsetObjective): RedirectResponse
    {
        $deleted = $unsetObjective->execute($objective, ObjectiveData::from($objective->toArray()));

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with deleting the Objective, please try again.');
        }

        return redirect()
            ->to(route('performance.index'))
            ->with('flash.success', 'Objective deleted!');
    }
}
