<?php

namespace App\Http\People\Controllers;

use App\Http\People\Requests\UpdatePersonProfileRequest;
use App\Http\People\ViewModels\PersonProfileViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\People\Actions\Contracts\UpdatePersonProfileActionInterface;
use Domain\People\Models\Person;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PersonProfileController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function edit(): Response
    {
        $this->authorize('update', person());

        return Inertia::render('People/Profile/Index', new PersonProfileViewModel());
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdatePersonProfileRequest $request, Person $person, UpdatePersonProfileActionInterface $updateProfile): RedirectResponse
    {
        $this->authorize('update', $person);

        $updated = $updateProfile->execute($person, $request->personProfileData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem when updating your Personal Information, please try again.');
        }

        return back()->with('flash.success', 'Personal Information successfully updated!');
    }
}
