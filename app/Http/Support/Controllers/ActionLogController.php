<?php

namespace App\Http\Support\Controllers;

use App\Http\Support\ViewModels\ActionLogViewModel;
use Inertia\Inertia;
use Inertia\Response;

class ActionLogController extends Controller
{
    public function show(string $type, int $id): Response
    {
        return Inertia::render('ActionLogs/Show', new ActionLogViewModel($type, $id));
    }
}
