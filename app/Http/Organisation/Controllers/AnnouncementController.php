<?php

namespace App\Http\Organisation\Controllers;

use App\Http\Organisation\ViewModels\OrganisationAnnouncementsViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class AnnouncementController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Organisation/Announcement/Index', new OrganisationAnnouncementsViewModel());
    }

    public function create(): Response
    {
        return Inertia::render('Organisation/Announcement/Create');
    }
}
