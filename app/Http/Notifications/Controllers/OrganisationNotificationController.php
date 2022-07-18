<?php

namespace App\Http\Notifications\Controllers;

use App\Http\Notifications\Requests\StoreNotificationRequest;
use App\Http\Notifications\ViewModels\OrganisationNotificationsViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrganisationNotificationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Organisation/Notification/Index', new OrganisationNotificationsViewModel());
    }

    public function create(): Response
    {
        return Inertia::render('Organisation/Notification/Create');
    }

    public function store(StoreNotificationRequest $request, CreateNotificationAction $createNotification): RedirectResponse
    {
        $createNotification->execute(
            new NotificationData(
                body: $request->validated('body'),
                notifiable_id: organisation()->id,
                notifiable_type: 'organisation',
                title: $request->validated('title'),
                link: $request->validated('link')
            )
        );

        return redirect(route('organisation.notifications'))
            ->with('flash.success', 'Organisation notification successfully created!');
    }
}
