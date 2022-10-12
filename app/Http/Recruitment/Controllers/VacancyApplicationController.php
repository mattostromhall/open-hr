<?php

namespace App\Http\Recruitment\Controllers;

use App\Http\Recruitment\ViewModels\VacancyApplicationViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Recruitment\Models\Vacancy;
use Inertia\Inertia;
use Inertia\Response;

class VacancyApplicationController extends Controller
{
    public function __invoke(string $public_id): Response
    {
        $vacancy = Vacancy::firstWhere('public_id', $public_id);

        return Inertia::render('Recruitment/Vacancies/Apply', new VacancyApplicationViewModel($vacancy));
    }
}
