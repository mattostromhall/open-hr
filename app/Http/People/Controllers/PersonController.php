<?php

namespace App\Http\People\Controllers;

use App\Http\People\ViewModels\PeopleViewModel;
use App\Http\People\ViewModels\PersonViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\People\Models\Person;
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
}
