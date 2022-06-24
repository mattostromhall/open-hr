<?php

namespace App\Http\People\Controllers;

use App\Http\People\ViewModels\PeopleViewModel;
use App\Http\People\ViewModels\PersonViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class PersonController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('People/Index', new PeopleViewModel());
    }

    public function edit(): Response
    {
        return Inertia::render('People/Edit', new PersonViewModel());
    }
}
