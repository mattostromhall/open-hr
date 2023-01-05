<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\ViewModels\TrainingIndexViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Models\Training;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;
use Inertia\Response;

class ManageTrainingController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(): Response
    {
        $this->authorize('manage', Training::class);

        return Inertia::render('Performance/Training/Manage', new TrainingIndexViewModel());
    }
}
