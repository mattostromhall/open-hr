<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreObjectiveRequest;
use App\Http\Performance\Requests\UpdateObjectiveRequest;
use App\Http\Performance\ViewModels\ObjectiveViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\AmendObjectiveAction;
use Domain\Performance\Actions\SetObjectiveAction;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\Objective;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ObjectiveTaskController extends Controller
{
    public function store(StoreObjectiveRequest $request, SetObjectiveAction $setObjective): RedirectResponse
    {
        $objective = $setObjective->execute(
            ObjectiveData::from($request->validatedData())
        );

        return redirect(route('objective.show', ['objective' => $objective]))
            ->with('flash.success', 'Task successfully created!');
    }

    public function edit(Objective $objective): Response
    {
        return Inertia::render('Performance/Objectives/Edit', new ObjectiveViewModel($objective));
    }

    public function update(UpdateObjectiveRequest $request, Objective $objective, AmendObjectiveAction $amendObjective): RedirectResponse
    {
        $objectiveData = ObjectiveData::from([
            ...$objective->only('title', 'description', 'due_at', 'completed_at'),
            ...$request->filteredValidatedData()
        ]);

        $updated = $amendObjective->execute($objective, $objectiveData);

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Task, please try again.');
        }

        return redirect(route('objective.show', ['objective' => $objective]))
            ->with('flash.success', 'Task successfully updated!');
    }
}
