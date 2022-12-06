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
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ObjectiveController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(StoreObjectiveRequest $request, SetObjectiveAction $setObjective): RedirectResponse
    {
        $this->authorize('create', Objective::class);

        $objective = $setObjective->execute($request->objectiveData());

        return redirect(route('objective.edit', ['objective' => $objective]))
            ->with('flash.success', 'Objective successfully created!');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Objective $objective): Response
    {
        $this->authorize('view', $objective);

        return Inertia::render('Performance/Objectives/Show', new ObjectiveViewModel($objective));
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Objective $objective): Response
    {
        $this->authorize('update', $objective);

        return Inertia::render('Performance/Objectives/Edit', new ObjectiveViewModel($objective));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateObjectiveRequest $request, Objective $objective, AmendObjectiveAction $amendObjective): RedirectResponse
    {
        $this->authorize('update', $objective);

        $updated = $amendObjective->execute($objective, $request->objectiveData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Objective, please try again.');
        }

        return redirect()
            ->to(route('performance.index'))
            ->with('flash.success', 'Objective updated!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Objective $objective, UnsetObjectiveAction $unsetObjective): RedirectResponse
    {
        $this->authorize('delete', $objective);

        $deleted = $unsetObjective->execute($objective, ObjectiveData::from($objective->toArray()));

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with unsetting the Objective, please try again.');
        }

        return redirect()
            ->to(route('performance.index', ['active' => 'create']))
            ->with('flash.success', 'Objective unset!');
    }
}
