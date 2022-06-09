<?php

namespace App\Http\People\Controllers;

use App\Http\People\Requests\UpdatePersonProfileRequest;
use App\Http\People\ViewModels\PersonProfileViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\People\Actions\UpdatePersonProfileAction;
use Domain\People\DataTransferObjects\PersonProfileData;
use Domain\People\Models\Person;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PersonProfileController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('People/Profile/Index', new PersonProfileViewModel());
    }

    public function update(UpdatePersonProfileRequest $request, Person $person, UpdatePersonProfileAction $updateProfile): RedirectResponse
    {
        $updated = $updateProfile->execute($person, PersonProfileData::from($request->validatedData()));

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem when updating your Personal Information, please try again.');
        }

        return back()->with('flash.success', 'Personal Information successfully updated!');
    }
}
