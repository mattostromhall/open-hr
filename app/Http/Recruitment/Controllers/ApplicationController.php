<?php

namespace App\Http\Recruitment\Controllers;

use App\Http\Recruitment\Requests\SubmitApplicationRequest;
use App\Http\Recruitment\ViewModels\ApplicationViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Recruitment\Actions\DeleteApplicationAction;
use Domain\Recruitment\Actions\SubmitApplicationAction;
use Domain\Recruitment\Models\Application;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ApplicationController extends Controller
{
    public function store(SubmitApplicationRequest $request, SubmitApplicationAction $submitApplication): RedirectResponse
    {
        $submitApplication->execute($request->submittedApplicationData());

        return redirect(route('application.thanks'));
    }

    public function show(Application $application): Response
    {
        return Inertia::render('Recruitment/Applications/Show', new ApplicationViewModel($application));
    }

    public function destroy(Application $application, DeleteApplicationAction $deleteApplication): RedirectResponse
    {
        $deleted = $deleteApplication->execute($application);

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with deleting the Application, please try again.');
        }

        return back()->with('flash.success', 'Application deleted!');
    }
}
