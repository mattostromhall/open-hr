<?php

namespace App\Http\Recruitment\Controllers;

use App\Http\Recruitment\Requests\StoreVacancyRequest;
use App\Http\Recruitment\Requests\UpdateVacancyRequest;
use App\Http\Recruitment\ViewModels\VacanciesViewModel;
use App\Http\Recruitment\ViewModels\VacancyViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Recruitment\Actions\CreateVacancyAction;
use Domain\Recruitment\Actions\UpdateVacancyAction;
use Domain\Recruitment\DataTransferObjects\VacancyData;
use Domain\Recruitment\Models\Vacancy;
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

    public function show(Vacancy $vacancy): Response
    {
        return Inertia::render('Recruitment/Vacancies/Show', new VacancyViewModel($vacancy));
    }

    public function edit(Vacancy $vacancy): Response
    {
        return Inertia::render('Recruitment/Vacancies/Edit', new VacancyViewModel($vacancy));
    }

    public function update(UpdateVacancyRequest $request, Vacancy $vacancy, UpdateVacancyAction $updateVacancy): RedirectResponse
    {
        $vacancyData = VacancyData::from([
            ...$vacancy->only('title', 'description', 'location', 'contract_type', 'contract_length', 'remuneration', 'remuneration_currency', 'open_at', 'close_at'),
            ...$request->filteredValidatedData()
        ]);

        $updated = $updateVacancy->execute($vacancy, $vacancyData);

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Vacancy, please try again.');
        }

        return redirect()->to(route('vacancy.index'))->with('flash.success', 'Vacancy updated!');
    }
}
