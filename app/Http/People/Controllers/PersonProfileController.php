<?php

namespace App\Http\People\Controllers;

use App\Http\People\ViewModels\PersonProfileViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class PersonProfileController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('People/Profile', new PersonProfileViewModel());
    }
}
