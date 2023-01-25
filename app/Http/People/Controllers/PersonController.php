<?php

namespace App\Http\People\Controllers;

use App\Http\People\Requests\DeletePersonRequest;
use App\Http\People\Requests\StorePersonUserRequest;
use App\Http\People\Requests\UpdatePersonRequest;
use App\Http\People\ViewModels\CreatePersonViewModel;
use App\Http\People\ViewModels\PeopleViewModel;
use App\Http\People\ViewModels\PersonViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\People\Actions\Contracts\CreatePersonUserActionInterface;
use Domain\People\Actions\Contracts\DeletePersonUserActionInterface;
use Domain\People\Actions\Contracts\UpdatePersonActionInterface;
use Domain\People\Models\Person;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PersonController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): Response
    {
        $this->authorize('viewAll', Person::class);

        return Inertia::render('People/Person/Index', new PeopleViewModel());
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('create', Person::class);

        return Inertia::render('People/Person/Create', new CreatePersonViewModel());
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StorePersonUserRequest $request, CreatePersonUserActionInterface $createPerson): RedirectResponse
    {
        $this->authorize('create', Person::class);

        DB::transaction(
            fn () => $createPerson->execute($request->personUserData())
        );

        return redirect(route('person.index'))
            ->with('flash.success', 'Person successfully created!');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Person $person): Response
    {
        $this->authorize('view', $person);

        return Inertia::render('People/Person/Show', new PersonViewModel($person));
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Person $person): Response
    {
        $this->authorize('update', $person);

        return Inertia::render('People/Person/Edit', new PersonViewModel($person));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdatePersonRequest $request, Person $person, UpdatePersonActionInterface $updatePerson): RedirectResponse
    {
        $this->authorize('update', $person);

        $updated = $updatePerson->execute($person, $request->personData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem updating the information, please try again.');
        }

        return back()->with('flash.success', 'Person successfully updated!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DeletePersonRequest $request, Person $person, DeletePersonUserActionInterface $deletePerson): RedirectResponse
    {
        $this->authorize('delete', $person);

        $deleted = DB::transaction(
            fn () => $deletePerson->execute($request->deletePersonData())
        );

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem deleting the Person, please try again.');
        }

        return redirect()
            ->to(route('person.index'))
            ->with('flash.success', 'Person deleted!');
    }
}
