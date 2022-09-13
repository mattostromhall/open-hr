<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreTrainingRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\RequestTrainingAction;
use Domain\Performance\DataTransferObjects\TrainingData;
use Illuminate\Http\RedirectResponse;

class ReviewTrainingController extends Controller
{
    public function show()
    {
        
    }
}
