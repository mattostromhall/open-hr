<?php

namespace App\Http\People\Controllers;

use App\Http\People\Requests\BulkDeletePeopleRequest;
use App\Http\Support\Controllers\Controller;
use Domain\People\Actions\Contracts\BulkDeletePeopleActionInterface;
use Domain\People\Models\Person;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class BulkDeletePeopleController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(BulkDeletePeopleRequest $request, BulkDeletePeopleActionInterface $bulkDelete): RedirectResponse
    {
        $this->authorize('bulkDelete', Person::class);

        $deleted = DB::transaction(
            fn () => $bulkDelete->execute($request->validated('people'))
        );

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem deleting the selected People, please try again.');
        }

        return back()->with('flash.success', 'Selected People deleted!');
    }
}
