<?php

namespace App\Http\Recruitment\Controllers;

use App\Http\Recruitment\ViewModels\VacanciesViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class VacancyController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Recruitment/Vacancies/Index', new VacanciesViewModel());
    }
}
