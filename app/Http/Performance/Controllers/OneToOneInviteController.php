<?php

namespace App\Http\Performance\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Performance\Models\OneToOne;
use Inertia\Inertia;
use Inertia\Response;

class OneToOneInviteController extends Controller
{
    public function show(OneToOne $oneToOne): Response
    {
        return Inertia::render();
    }
}
