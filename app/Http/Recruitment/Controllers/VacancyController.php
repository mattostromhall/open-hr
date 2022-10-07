<?php

namespace App\Http\Recruitment\Controllers;

use App\Http\Recruitment\Requests\StoreVacancyRequest;
use App\Http\Recruitment\ViewModels\VacanciesViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Recruitment\Actions\CreateVacancyAction;
use Domain\Recruitment\DataTransferObjects\VacancyData;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class VacancyController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Recruitment/Vacancies/Index', new VacanciesViewModel());
    }

    public function store(StoreVacancyRequest $request, CreateVacancyAction $createVacancy): RedirectResponse
    {
        $createVacancy->execute(
            VacancyData::from($request->validatedData())
        );

        return back()->with('flash.success', 'Vacancy posted!');
    }
}
