<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\UpdateOneToOneRequest;
use App\Http\Performance\ViewModels\OneToOneViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\OneToOneInviteResponseAction;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class OneToOneInviteController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function show(OneToOne $oneToOne): Response
    {
        $this->authorize('view', $oneToOne);

        return Inertia::render('Performance/OneToOnes/Invite', new OneToOneViewModel($oneToOne));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateOneToOneRequest $request, OneToOne $oneToOne, OneToOneInviteResponseAction $inviteResponse): RedirectResponse
    {
        $this->authorize('update', $oneToOne);

        DB::transaction(
            fn () => $inviteResponse->execute($oneToOne, $request->oneToOneData())
        );

        return redirect(route('performance.index'))->with('flash.success', 'One-to-one updated!');
    }
}
