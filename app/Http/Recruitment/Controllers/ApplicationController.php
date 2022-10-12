<?php

namespace App\Http\Recruitment\Controllers;

use App\Http\Recruitment\Requests\SubmitApplicationRequest;
use App\Http\Recruitment\ViewModels\ApplicationViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Recruitment\Actions\SubmitApplicationAction;
use Domain\Recruitment\DataTransferObjects\SubmittedApplicationData;
use Domain\Recruitment\Models\Application;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ApplicationController extends Controller
{
    public function store(SubmitApplicationRequest $request, SubmitApplicationAction $submitApplication): RedirectResponse
    {
        $submitApplication->execute(
            SubmittedApplicationData::from($request->validatedData())
        );

        return redirect(route('application.thanks'));
    }

    public function show(Application $application): Response
    {
        return Inertia::render('Recruitment/Applications/Show', new ApplicationViewModel($application));
    }
}
