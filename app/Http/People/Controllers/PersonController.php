<?php

namespace App\Http\People\Controllers;

use App\Http\People\Requests\UpdatePersonRequest;
use App\Http\People\ViewModels\PeopleViewModel;
use App\Http\People\ViewModels\PersonViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\People\Actions\UpdatePersonAction;
use Domain\People\DataTransferObjects\PersonData;
use Domain\People\Models\Person;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PersonController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('People/Person/Index', new PeopleViewModel());
    }

    public function edit(Person $person): Response
    {
        return Inertia::render('People/Person/Edit', new PersonViewModel($person));
    }

    public function update(UpdatePersonRequest $request, Person $person, UpdatePersonAction $updatePerson): RedirectResponse
    {
        $updated = $updatePerson->execute(
            $person,
            PersonData::from($request->validatedData())
        );

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem updating the information, please try again.');
        }

        return back()->with('flash.success', 'Person successfully updated!');
    }
}
