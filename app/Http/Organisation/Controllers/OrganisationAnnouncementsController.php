<?php

namespace App\Http\Organisation\Controllers;

use App\Http\Organisation\ViewModels\OrganisationAnnouncementsViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class OrganisationAnnouncementsController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Organisation/Announcements', new OrganisationAnnouncementsViewModel());
    }
}
