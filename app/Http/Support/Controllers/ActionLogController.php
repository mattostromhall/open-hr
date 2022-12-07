<?php

namespace App\Http\Support\Controllers;

use App\Http\Support\ViewModels\ActionLogViewModel;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;
use Inertia\Response;
use Support\Models\ActionLog;

class ActionLogController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function show(string $type, int $id): Response
    {
        $this->authorize('view', ActionLog::class);

        return Inertia::render('ActionLogs/Show', new ActionLogViewModel($type, $id));
    }
}
