<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreOneToOneRequest;
use App\Http\Performance\Requests\UpdateOneToOneRequest;
use App\Http\Performance\ViewModels\OneToOneViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\AmendOneToOneAction;
use Domain\Performance\Actions\CancelOneToOneAction;
use Domain\Performance\Actions\ScheduleOneToOneAction;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OneToOneController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(StoreOneToOneRequest $request, ScheduleOneToOneAction $scheduleOneToOne): RedirectResponse
    {
        $this->authorize('create', OneToOne::class);

        $scheduleOneToOne->execute($request->oneToOneData());

        return back()->with('flash.success', 'One-to-one requested!');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(OneToOne $oneToOne): Response
    {
        $this->authorize('view', $oneToOne);

        return Inertia::render('Performance/OneToOnes/Show', new OneToOneViewModel($oneToOne));
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(OneToOne $oneToOne): Response
    {
        $this->authorize('update', $oneToOne);

        return Inertia::render('Performance/OneToOnes/Edit', new OneToOneViewModel($oneToOne));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateOneToOneRequest $request, OneToOne $oneToOne, AmendOneToOneAction $amendOneToOne): RedirectResponse
    {
        $this->authorize('update', $oneToOne);

        $updated = $amendOneToOne->execute($oneToOne, $request->oneToOneData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the One-to-one, please try again.');
        }

        return redirect()->to(route('performance.index'))->with('flash.success', 'One-to-one updated!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(OneToOne $oneToOne, CancelOneToOneAction $cancelOneToOne): RedirectResponse
    {
        $this->authorize('delete', $oneToOne);

        $deleted = $cancelOneToOne->execute($oneToOne, OneToOneData::from($oneToOne->toArray()));

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with cancelling the One-to-one, please try again.');
        }

        return redirect()->to(route('performance.index'))->with('flash.success', 'One-to-one cancelled!');
    }
}
