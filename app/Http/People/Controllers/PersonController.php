<?php

namespace App\Http\People\Controllers;

use App\Http\People\Requests\StorePersonUserRequest;
use App\Http\People\Requests\UpdatePersonRequest;
use App\Http\People\ViewModels\CreatePersonViewModel;
use App\Http\People\ViewModels\PeopleViewModel;
use App\Http\People\ViewModels\PersonViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\People\Actions\CreatePersonUserAction;
use Domain\People\Actions\DeletePersonUserAction;
use Domain\People\Actions\UpdatePersonAction;
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

    public function create(): Response
    {
        return Inertia::render('People/Person/Create', new CreatePersonViewModel());
    }

    public function store(StorePersonUserRequest $request, CreatePersonUserAction $createPerson): RedirectResponse
    {
        $createPerson->execute($request->personUserData());

        return redirect(route('person.index'))
            ->with('flash.success', 'Person successfully created!');
    }

    public function show(Person $person): Response
    {
        return Inertia::render('People/Person/Show', new PersonViewModel($person));
    }

    public function edit(Person $person): Response
    {
        return Inertia::render('People/Person/Edit', new PersonViewModel($person));
    }

    public function update(UpdatePersonRequest $request, Person $person, UpdatePersonAction $updatePerson): RedirectResponse
    {
        $updated = $updatePerson->execute($person, $request->personData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem updating the information, please try again.');
        }

        return back()->with('flash.success', 'Person successfully updated!');
    }

    public function destroy(Person $person, DeletePersonUserAction $deletePerson): RedirectResponse
    {
        $deleted = $deletePerson->execute($person, $person->user);

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem deleting the Person, please try again.');
        }

        return redirect()
            ->to(route('person.index'))
            ->with('flash.success', 'Person deleted!');
    }
}
