<?php

namespace App\Http\Notifications\ViewModels;

use App\Http\Support\ViewModels\ViewModel;

class OrganisationNotificationsViewModel extends ViewModel
{
    public function organisationNotifications()
    {
        return organisation()->notifications;
    }
}
