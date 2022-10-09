<?php

namespace App\Http\Recruitment\Controllers;

use App\Http\Recruitment\ViewModels\VacanciesViewModel;
use App\Http\Recruitment\ViewModels\VacancyViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Recruitment\Models\Vacancy;
use Inertia\Inertia;
use Inertia\Response;

class VacancyApplicationController extends Controller
{
    public function __invoke(Vacancy $vacancy): Response
    {
        return Inertia::render('Recruitment/Vacancies/Apply', new VacancyViewModel($vacancy));
    }
}
