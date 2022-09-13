<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreTrainingRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\RequestTrainingAction;
use Domain\Performance\DataTransferObjects\TrainingData;
use Illuminate\Http\RedirectResponse;

class TrainingController extends Controller
{
    public function store(StoreTrainingRequest $request, RequestTrainingAction $requestTraining): RedirectResponse
    {
        $requestTraining->execute(
            TrainingData::from($request->validatedData())
        );

        return back()->with('flash.success', 'Training request submitted!');
    }
}
