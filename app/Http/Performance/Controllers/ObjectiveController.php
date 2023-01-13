<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreObjectiveRequest;
use App\Http\Performance\Requests\UpdateObjectiveRequest;
use App\Http\Performance\ViewModels\ObjectiveViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\Contracts\AmendObjectiveActionInterface;
use Domain\Performance\Actions\Contracts\SetObjectiveActionInterface;
use Domain\Performance\Actions\Contracts\UnsetObjectiveActionInterface;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ObjectiveController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(StoreObjectiveRequest $request, SetObjectiveActionInterface $setObjective): RedirectResponse
    {
        $this->authorize('create', Objective::class);

        $objective = DB::transaction(
            fn () => $setObjective->execute($request->objectiveData())
        );

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
    public function update(UpdateObjectiveRequest $request, Objective $objective, AmendObjectiveActionInterface $amendObjective): RedirectResponse
    {
        $this->authorize('update', $objective);

        $updated = DB::transaction(
            fn () => $amendObjective->execute($objective, $request->objectiveData())
        );

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
    public function destroy(Objective $objective, UnsetObjectiveActionInterface $unsetObjective): RedirectResponse
    {
        $this->authorize('delete', $objective);

        $deleted = DB::transaction(
            fn () => $unsetObjective->execute($objective, ObjectiveData::from($objective->toArray()))
        );

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with unsetting the Objective, please try again.');
        }

        return redirect()
            ->to(route('performance.index', ['active' => 'create']))
            ->with('flash.success', 'Objective unset!');
    }
}
