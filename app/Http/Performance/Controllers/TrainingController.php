<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreTrainingRequest;
use App\Http\Performance\ViewModels\TrainingIndexViewModel;
use App\Http\Performance\ViewModels\TrainingViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\RequestTrainingAction;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TrainingController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Performance/Training/Index', new TrainingIndexViewModel());
    }

    public function store(StoreTrainingRequest $request, RequestTrainingAction $requestTraining): RedirectResponse
    {
        $requestTraining->execute(
            TrainingData::from($request->validatedData())
        );

        return back()->with('flash.success', 'Training request submitted!');
    }

    public function show(Training $training): Response
    {
        return Inertia::render('Performance/Training/Show', new TrainingViewModel($training));
    }
}
