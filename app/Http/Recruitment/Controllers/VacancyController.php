<?php

namespace App\Http\Recruitment\Controllers;

use App\Http\Recruitment\Requests\StoreVacancyRequest;
use App\Http\Recruitment\Requests\UpdateVacancyRequest;
use App\Http\Recruitment\ViewModels\VacanciesViewModel;
use App\Http\Recruitment\ViewModels\VacancyViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Recruitment\Actions\Contracts\CreateVacancyActionInterface;
use Domain\Recruitment\Actions\Contracts\DeleteVacancyActionInterface;
use Domain\Recruitment\Actions\Contracts\UpdateVacancyActionInterface;
use Domain\Recruitment\Models\Vacancy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class VacancyController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): Response
    {
        $this->authorize('viewAll', Vacancy::class);

        return Inertia::render('Recruitment/Vacancies/Index', new VacanciesViewModel());
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreVacancyRequest $request, CreateVacancyActionInterface $createVacancy): RedirectResponse
    {
        $this->authorize('create', Vacancy::class);

        $createVacancy->execute($request->vacancyData());

        return back()->with('flash.success', 'Vacancy posted!');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Vacancy $vacancy): Response
    {
        $this->authorize('view', $vacancy);

        return Inertia::render('Recruitment/Vacancies/Show', new VacancyViewModel($vacancy));
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Vacancy $vacancy): Response
    {
        $this->authorize('update', $vacancy);

        return Inertia::render('Recruitment/Vacancies/Edit', new VacancyViewModel($vacancy));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateVacancyRequest $request, Vacancy $vacancy, UpdateVacancyActionInterface $updateVacancy): RedirectResponse
    {
        $this->authorize('update', $vacancy);

        $updated = $updateVacancy->execute($vacancy, $request->vacancyData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Vacancy, please try again.');
        }

        return redirect()->to(route('vacancy.index'))->with('flash.success', 'Vacancy updated!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Vacancy $vacancy, DeleteVacancyActionInterface $deleteVacancy): RedirectResponse
    {
        $this->authorize('delete', $vacancy);

        $deleted = $deleteVacancy->execute($vacancy);

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with deleting the Vacancy, please try again.');
        }

        return redirect()->to(route('vacancy.index'))->with('flash.success', 'Vacancy deleted!');
    }
}
