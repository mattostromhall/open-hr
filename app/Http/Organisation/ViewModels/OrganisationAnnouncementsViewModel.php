<?php

namespace App\Http\Organisation\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Absences\Models\Holiday;
use Domain\Organisation\Models\Organisation;

class OrganisationAnnouncementsViewModel extends ViewModel
{
    public function announcements()
    {
        return organisation()->announcements;
    }
}
