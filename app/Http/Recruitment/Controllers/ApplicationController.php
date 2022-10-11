<?php

namespace App\Http\Recruitment\Controllers;

use App\Http\Recruitment\Requests\SubmitApplicationRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Recruitment\Actions\SubmitApplicationAction;
use Domain\Recruitment\DataTransferObjects\SubmittedApplicationData;
use Illuminate\Http\RedirectResponse;

class ApplicationController extends Controller
{
    public function store(SubmitApplicationRequest $request, SubmitApplicationAction $submitApplication): RedirectResponse
    {
        $submitApplication->execute(
            SubmittedApplicationData::from($request->validatedData())
        );

        return redirect(route('application.thanks'));
    }
}
